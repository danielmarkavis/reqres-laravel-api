<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\Paginator;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository) {}

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(Request $request): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $page = $request->input('page', 1);
        $per_page = $request->input('per_page', 5);
        try {
            $response = $this->userRepository->index($page, $per_page);
        } catch (RequestException $e) {
            abort( response($e->getMessage(),Response::HTTP_NOT_FOUND));
        }

        $users = $response['data'];
        $links = $response['links'];

        return view('users.index', compact('users','links'));
    }

    /**
     * @param int $user_id
     *
     * @return JsonResponse
     */
    public function show(int $user_id): JsonResponse
    {
        try {
            $data = $this->userRepository->show($user_id);
        } catch (RequestException $e) {
            abort( response(["message"=>$e->getMessage()], Response::HTTP_NOT_FOUND) );
        }
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): JsonResponse
    {
        try {
            $data = $this->userRepository->store([
                "first_name" => "Laurence",
                "last_name" => "Fishburne",
                "job" => "leader",
                "email" => "nebuchadnezzar@zion.com",
                "avatar" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/ab/Morpheus.jpg/220px-Morpheus.jpg"
            ]);
        } catch (RequestException $e) {
            abort( response(["message"=>$e->getMessage()], Response::HTTP_NOT_FOUND) );
        }
        return response()->json($data);
    }

}

