<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private $userApi = "/api/users/";

    /**
     * A basic index user feature test.
     */
    public function test_users_index(): void
    {
        $response = $this->getAllUser();

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
     * A basic store user feature test.
     */
    public function test_users_store(): void
    {
        $payload = [];

        $response = $this->storeUser($payload);

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
            'first_name' => 'Alex',
            'last_name' => 'Bro',
        ];

        $response = $this->storeUser($payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'first_name' => $payload['first_name'],
                    'last_name' => $payload['last_name'],
                ]
            ]);
    }

    /**
     * A basic show user feature test.
     */
    public function test_users_show(): void
    {
        $payload = [
            'first_name' => 'Alex',
            'last_name' => 'Bro',
        ];

        $user = $this->storeUser($payload)->getOriginalContent()['data'];

        $response = $this->json('get', "/api/users/$user->id");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'first_name' => $payload['first_name'],
                    'last_name' => $payload['last_name'],
                ]
            ]);
    }

    /**
     * A basic update user feature test.
     */
    public function test_users_update(): void
    {
        $user = $this->storeUser([
                'first_name' => 'Alex',
                'last_name' => 'Bro',])
            ->getOriginalContent()['data'];

        $payload = [
            'first_name' => 'Sebastian'
        ];

        $response = $this->updateUser($user->id, $payload);

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
     * A basic delete user feature test.
     */
    public function test_users_delete(): void
    {
        $user = $this->storeUser([
            'first_name' => 'Alex',
            'last_name' => 'Bro',])
            ->getOriginalContent()['data'];

        $response = $this->deleteUser($user->id);

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

        $response = $this->getUser($user->id);

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

    private function getAllUser(array $payload = [])
    {
        return $this->json('get', $this->userApi, $payload);
    }

    private function getUser($id)
    {
        return $this->json('get', $this->userApi . $id);
    }

    private function storeUser(array $payload)
    {
        return $this->json('post', $this->userApi, $payload);
    }

    private function updateUser($id, array $payload)
    {
        return $this->json('put', $this->userApi . $id, $payload);
    }

    private function deleteUser($id)
    {
        return $this->json('delete', $this->userApi . $id);
    }
}
