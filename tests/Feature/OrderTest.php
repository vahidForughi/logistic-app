<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Repositories\CarDefaultRepository;
use App\Repositories\UserDefaultRepository;
use App\Services\CarService;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private $orderApi = "/api/orders/";

    private UserService $userService;

    private CarService $carService;

    /**
     * A basic index order feature test.
     */
    public function test_orders_index(): void
    {
        $response = $this->getAllOrder();

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
     * A basic store order feature test.
     */
    public function test_orders_store(): void
    {
        $this->seed();

        $this->userService = new UserService(new UserDefaultRepository());
        $this->carService = new CarService(new CarDefaultRepository());
        $user = $this->userService->first();
        $car = $this->carService->first();

        $payload = [];

        $response = $this->storeOrder($payload);

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
            'user_id' => $user->id,
            'car_id' => $car->id,
        ];

        $response = $this->storeOrder($payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'user_id' => $payload['user_id'],
                    'car_id' => $payload['car_id'],
                ]
            ]);
    }

    /**
     * A basic show order feature test.
     */
    public function test_orders_show(): void
    {
        $this->seed();

        $this->userService = new UserService(new UserDefaultRepository());
        $this->carService = new CarService(new CarDefaultRepository());
        $user = $this->userService->first();
        $car = $this->carService->first();

        $payload = [
            'user_id' => $user->id,
            'car_id' => $car->id,
        ];

        $order = $this->storeOrder($payload)->getOriginalContent()['data'];

        $response = $this->getOrder($order->id);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $order->id,
                    'user_id' => $payload['user_id'],
                    'car_id' => $payload['car_id'],
                ]
            ]);
    }

    /**
     * A basic update order feature test.
     */
    public function test_orders_update(): void
    {
        $this->seed();

        $this->userService = new UserService(new UserDefaultRepository());
        $this->carService = new CarService(new CarDefaultRepository());
        $user = $this->userService->first();
        $car = $this->carService->first();

        $order = $this->storeOrder([
                'user_id' => $user->id,
                'car_id' => $car->id,
            ])
            ->getOriginalContent()['data'];

        $car = $this->carService->get(1);

        $payload = [
            'car_id' => $car->id
        ];

        $response = $this->updateOrder($order->id, $payload);

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
     * A basic delete order feature test.
     */
    public function test_orders_delete(): void
    {
        $this->seed();

        $this->userService = new UserService(new UserDefaultRepository());
        $this->carService = new CarService(new CarDefaultRepository());
        $user = $this->userService->first();
        $car = $this->carService->first();

        $order = $this->storeOrder([
                'user_id' => $user->id,
                'car_id' => $car->id,
            ])
            ->getOriginalContent()['data'];

        $response = $this->deleteOrder($order->id);

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

        $response = $this->getOrder($order->id);

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

    private function getAllOrder(array $payload = [])
    {
        return $this->json('get', $this->orderApi, $payload);
    }

    private function getOrder($id)
    {
        return $this->json('get', $this->orderApi . $id);
    }

    private function storeOrder(array $payload)
    {
        return $this->json('post', $this->orderApi, $payload);
    }

    private function updateOrder($id, array $payload)
    {
        return $this->json('put', $this->orderApi . $id, $payload);
    }

    private function deleteOrder($id)
    {
        return $this->json('delete', $this->orderApi . $id);
    }
}
