<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\UserRegistrationService;
use App\Http\Requests\StoreRegisterRequest;

class RegisterUser extends Controller
{
    public function __invoke(StoreRegisterRequest $request, UserRegistrationService $registrationService): JsonResponse
    {
        $result = $registrationService->register($request->validated());
        
        return response()->json($result, 201);
    }
}