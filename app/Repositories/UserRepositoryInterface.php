<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAll(): array;
    public function findById(string $id): User;
    public function store(array $data): User;
    public function update(string $id, array $data): void;
    public function delete(string $id): void;
}
