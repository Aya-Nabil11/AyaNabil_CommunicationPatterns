<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Create new announcement
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string',
            'message' => 'required|string'
        ]);

        $announcement = Announcement::create($request->all());

        // Here we would also publish to Redis for live users
        // Redis::publish('announcements', json_encode($announcement));

        return response()->json(['message' => 'Announcement created', 'data' => $announcement], 201);
    }

    // Fetch all announcements (for offline users when they return)
    public function index()
    {
        return Announcement::latest()->take(20)->get();
    }
}
