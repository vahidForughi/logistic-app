<?php

namespace App\Repositories;

use App\Models\Car;

interface CarRepositoryInterface
{
    public function getAll(): array;
    public function get(int $num): Car;
    public function first(): Car;
    public function findById(string $id): Car;
    public function store(array $data): Car;
    public function update(string $id, array $data): void;
    public function delete(string $id): void;
}
