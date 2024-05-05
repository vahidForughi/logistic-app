<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->jsonSuccess($this->userService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        return response()->jsonSuccess($this->userService->store([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->jsonSuccess($this->userService->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $this->userService->update($id, [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name
        ]);

        return response()->jsonSuccess(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);

        return response()->jsonSuccess(true);
    }
}
