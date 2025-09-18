<?php

namespace App\Http\Controllers;

use App\Models\DriverLocation;
use Illuminate\Http\Request;

class DriverLocationController extends Controller
{
    public function update(Request $request, $orderId)
    {
        $request->validate([
            'driver_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $location = DriverLocation::updateOrCreate(
            ['order_id' => $orderId],
            [
                'driver_id' => $request->driver_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        // Broadcast location update via WebSocket (pseudo)
        // event(new DriverLocationUpdated($location));

        return response()->json(['message' => 'Location updated', 'location' => $location]);
    }
}