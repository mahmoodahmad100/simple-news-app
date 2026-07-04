<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function login(array $data): User
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if (!$user || !password_verify($data['password'], $user->password)) {
            throw new \InvalidArgumentException('Invalid credentials');
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token = $token;

        return $user;
    }
}