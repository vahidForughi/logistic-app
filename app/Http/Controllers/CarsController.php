<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    public function __construct(
        private CarService $carService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->jsonSuccess($this->carService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarStoreRequest $request)
    {
        return response()->jsonSuccess($this->carService->store([
            'model' => $request->model,
            'brand' => $request->brand
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->jsonSuccess($this->carService->findById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, string $id)
    {
        $this->carService->update($id, [
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
        $this->carService->delete($id);
    }
}
