<?php

namespace App\Services;

use App\Models\Car;
use App\Repositories\CarRepositoryInterface;

class CarService
{
    public function __construct(
        protected CarRepositoryInterface $carService
    ) {}


    public function getAll(): array
    {
        return $this->carService->getAll();
    }

    public function get(int $num): Car
    {
        return $this->carService->get($num);
    }

    public function first(): Car
    {
        return $this->carService->first();
    }

    public function findById(string $id): Car
    {
        return $this->carService->findById($id);
    }

    public function store(array $data): Car
    {
        return $this->carService->store($data);
    }

    public function update(string $id, array $data): bool
    {
        $this->carService->update($id, $data);

        return true;
    }

    public function delete(string $id): bool
    {
        $this->carService->delete($id);

        return true;
    }
}
