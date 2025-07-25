<?php

namespace App\Services;

use App\Models\User;

class UserRegistrationService
{
    public function register(array $data): array
    {
        $user = User::create([
            'full_name' => $data['full_name'],
            'password' => $data['password'],
        ]);

        return [
            'success' => true,
            'message' => 'Registration successful',
            'user' => $user,
        ];
    }
}
