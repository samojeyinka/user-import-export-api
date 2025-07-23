<?php
namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class IndexUser extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $users = User::all();
            return response()->json([
                'success' => true,
                'data' => $users,
                'count' => $users->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching users: ' . $e->getMessage()
            ], 500);
        }
    }
}
