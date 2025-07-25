<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IndexUser extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $users = User::all();

            return response()->json([
                'success' => true,
                'data' => $users,
                'count' => $users->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: '.$e->getMessage(),
            ], 500);
        }
    }
}
