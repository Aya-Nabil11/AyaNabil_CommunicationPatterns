<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Customer places a new order
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|integer',
            'restaurant_id' => 'required|integer',
            'items'         => 'required|array'
        ]);

        $order = Order::create([
            'user_id'       => $request->user_id,
            'restaurant_id' => $request->restaurant_id,
            'items'         => json_encode($request->items),
            'status'        => 'confirmed',
        ]);

        // Normally, broadcast event to WebSocket here
        // Example: event(new OrderCreated($order));

        return response()->json(['message' => 'Order placed', 'order' => $order], 201);
    }
}
