<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->jsonSuccess(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
        ]);

        return response()->jsonSuccess($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->jsonSuccess(Order::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
