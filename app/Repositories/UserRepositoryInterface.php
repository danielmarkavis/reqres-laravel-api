<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function index(int $page, int $per_page = 10);

    public function show(int $user_id);

    public function store(array $data);
}