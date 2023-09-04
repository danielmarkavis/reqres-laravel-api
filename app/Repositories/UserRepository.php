<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Http\Resources\PaginateResource;
use Illuminate\Support\Facades\Http;

class UserRepository implements UserRepositoryInterface
{

    public function __construct(private readonly string $url) {}

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function index(int $page = 1, int $per_page = 10): array
    {
        $response = Http::withQueryParameters([
            "page"     => $page,
            "per_page" => $per_page,
        ])->get($this->url)->throw()->object();
        return PaginateResource::make($response)->resolve();
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function show(int $user_id): array
    {
        $url = sprintf("%s/%s", $this->url, $user_id);
        $response = Http::get($url)->throw()->object();
        return UserResource::make($response->data)->resolve();
    }

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function store(array $data): array
    {
        $response = Http::post($this->url, $data)->throw()->object();
        return UserResource::make($response)->resolve();
    }

}