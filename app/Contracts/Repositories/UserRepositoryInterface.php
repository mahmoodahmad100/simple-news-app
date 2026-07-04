<?php

namespace App\Contracts\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findOrFail(int $id): User;

    public function update(User $user, array $data): void;
}