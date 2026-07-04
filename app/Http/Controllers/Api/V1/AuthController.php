<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * 
     */
    public function login(LoginRequest $request): UserResource
    {
        return new UserResource($this->authService->login($request->validated()));
    }
}