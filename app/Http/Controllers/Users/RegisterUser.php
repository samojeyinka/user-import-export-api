<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Services\UserRegistrationService;
use Illuminate\Http\JsonResponse;

class RegisterUser extends Controller
{
    public function __invoke(StoreRegisterRequest $request, UserRegistrationService $registrationService): JsonResponse
    {
        $result = $registrationService->register($request->validated());

        return response()->json($result, 201);
    }
}
