<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userService
    ) {}


    public function getAll(): array
    {
        return $this->userService->getAll();
    }

    public function findById(string $id): User
    {
        return $this->userService->findById($id);
    }

    public function store(array $data): User
    {
        return $this->userService->store($data);
    }

    public function update(string $id, array $data): bool
    {
        $this->userService->update($id, $data);

        return true;
    }

    public function delete(string $id): bool
    {
        $this->userService->delete($id);

        return true;
    }
}
