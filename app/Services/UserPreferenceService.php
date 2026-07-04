<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserPreferenceService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function update(User $user, array $data): void
    {
        //...
    }

    public function get(User $user): array
    {
        return [];
    }
}