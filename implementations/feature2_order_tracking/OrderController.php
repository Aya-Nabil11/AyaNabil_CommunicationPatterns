<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    // Update order status (restaurant or system would call this)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated', 'order' => $order]);
    }

    // Stream order status to customer using SSE
    public function track($id)
    {
        $response = new StreamedResponse(function () use ($id) {
            while (true) {
                $order = Order::find($id);

                if ($order) {
                    echo "data: " . json_encode(['status' => $order->status]) . "\n\n";
                    ob_flush();
                    flush();
                }

                sleep(10); // check every 10s
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}