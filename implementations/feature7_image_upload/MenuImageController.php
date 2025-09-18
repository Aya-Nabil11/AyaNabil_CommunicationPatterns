<?php

namespace App\Http\Controllers;

use App\Models\MenuImage;
use Illuminate\Http\Request;

class MenuImageController extends Controller
{
    // Handle upload
    public function upload(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|integer',
            'image' => 'required|file|mimes:jpeg,png|max:10240' // 10MB
        ]);

        $path = $request->file('image')->store('menu_images', 'public');

        $menuImage = MenuImage::create([
            'restaurant_id' => $request->restaurant_id,
            'path'          => $path,
            'status'        => 'uploaded',
        ]);

        // Dispatch background job
        // ProcessMenuImage::dispatch($menuImage);

        return response()->json([
            'message' => 'Image uploaded, processing started',
            'id'      => $menuImage->id,
        ]);
    }

    // Get status (polling fallback if SSE not available)
    public function status($id)
    {
        $menuImage = MenuImage::findOrFail($id);
        return response()->json(['status' => $menuImage->status]);
    }
}
