<?php

namespace App\Repositories;

use App\Models\User;

class UserDefaultRepository implements UserRepositoryInterface
{

    public function getAll(): array
    {
        return User::paginate()->toArray();
    }

    public function findById(string $id): User
    {
        return User::findOrFail($id);
    }

    public function store(array $data): User
    {
        $user = new User;
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->save();

        return $user;
    }

    public function update(string $id, array $data): void
    {
        $user = $this->findById($id);

        if (isset($data['first_name']))
            $user->first_name = $data['first_name'];

        if (isset($data['last_name']))
            $user->last_name = $data['last_name'];

        $user->save();
    }

    public function delete(string $id): void
    {
        $user = $this->findById($id);
        $user->delete();
    }
}
