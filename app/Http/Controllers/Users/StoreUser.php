<?php
namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class StoreUser extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'password' => $validated['password'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }
}
