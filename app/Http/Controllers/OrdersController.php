<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderIndexRequest $request)
    {
        $orders = Order::with('user','car');

        if ($request->user_id)
            $orders = $orders->whereUserId(intVal($request->user_id));

        if ($request->user_name)
            $orders = $orders->whereHas('user', function($query) use ($request) {
               return $query->whereName($request->user_name);
            });

        if ($request->car_id)
            $orders = $orders->whereCarId(intVal($request->car_id));

        if ($request->car_brand)
            $orders = $orders->whereHas('car', function($query) use ($request) {
                return $query->whereBrand($request->car_brand);
            });

        $orders = $orders->paginate();

        return response()->jsonSuccess($orders);
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
    public function show(Order $order)
    {
        return response()->jsonSuccess($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        if ($request->user_id)
            $order->user_id = $request->user_id;

        if ($request->car_id)
            $order->car_id = $request->car_id;

        $order->save();

        return response()->jsonSuccess(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->jsonSuccess(true);
    }
}
