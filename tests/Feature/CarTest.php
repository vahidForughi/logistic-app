<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    private $carApi = "/api/cars/";

    /**
     * A basic index car feature test.
     */
    public function test_cars_index(): void
    {
        $response = $this->getAllCar();

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
            ]);
    }

    /**
     * A basic store car feature test.
     */
    public function test_cars_store(): void
    {
        $payload = [];

        $response = $this->storeCar($payload);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'errors',
            ])
            ->assertJson([
                'success' => false,
            ]);

        $payload = [
            'brand' => 'BMW',
            'model' => 'E30',
        ];

        $response = $this->storeCar($payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'brand' => $payload['brand'],
                    'model' => $payload['model'],
                ]
            ]);
    }

    /**
     * A basic show car feature test.
     */
    public function test_cars_show(): void
    {
        $payload = [
            'brand' => 'BMW',
            'model' => 'E30',
        ];

        $car = $this->storeCar($payload)->getOriginalContent()['data'];

        $response = $this->getCar($car->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $car->id,
                    'brand' => $payload['brand'],
                    'model' => $payload['model'],
                ]
            ]);
    }

    /**
     * A basic update car feature test.
     */
    public function test_cars_update(): void
    {
        $car = $this->storeCar([
                'brand' => 'HONDA',
                'model' => 'Civic',])
            ->getOriginalContent()['data'];

        $payload = [
            'model' => 'S2000'
        ];

        $response = $this->updateCar($car->id, $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => true
            ]);
    }

    /**
     * A basic delete car feature test.
     */
    public function test_cars_delete(): void
    {
        $car = $this->storeCar([
            'brand' => 'BENZ',
            'model' => 'E330',])
            ->getOriginalContent()['data'];

        $response = $this->deleteCar($car->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => true
            ]);

        $response = $this->getCar($car->id);

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'errors',
            ])
            ->assertJson([
                'success' => false,
            ]);
    }

    private function getAllCar(array $payload = [])
    {
        return $this->json('get', $this->carApi, $payload);
    }

    private function getCar($id)
    {
        return $this->json('get', $this->carApi . $id);
    }

    private function storeCar(array $payload)
    {
        return $this->json('post', $this->carApi, $payload);
    }

    private function updateCar($id, array $payload)
    {
        return $this->json('put', $this->carApi . $id, $payload);
    }

    private function deleteCar($id)
    {
        return $this->json('delete', $this->carApi . $id);
    }
}
