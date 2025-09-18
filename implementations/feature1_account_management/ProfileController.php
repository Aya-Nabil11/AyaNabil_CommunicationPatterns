<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'nullable|string',
            'phone' => 'nullable|string'
        ]);

        $user->update($data);

        return response()->json($user);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }
}
