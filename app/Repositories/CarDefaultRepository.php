<?php

namespace App\Repositories;

use App\Models\Car;

class CarDefaultRepository implements CarRepositoryInterface
{

    public function getAll(): array
    {
        return Car::paginate()->toArray();
    }

    public function get(int $num): Car
    {
        return Car::skip($num)->take(1)->first();
    }

    public function first(): Car
    {
        return Car::firstOrFail();
    }

    public function findById(string $id): Car
    {
        return Car::findOrFail($id);
    }

    public function store(array $data): Car
    {
        $car = new Car;
        $car->brand = Car::CAR_BRANDS[$data['brand']];
        $car->model = $data['model'];
        $car->save();

        return $car;
    }

    public function update(string $id, array $data): void
    {
        $car = $this->findById($id);

        if (isset($data['first_name']))
            $car->brand = Car::CAR_BRANDS[$data['brand']];

        if (isset($data['last_name']))
            $car->model = $data['model'];

        $car->save();
    }

    public function delete(string $id): void
    {
        $car = $this->findById($id);
        $car->delete();
    }
}
