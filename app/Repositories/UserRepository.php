<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(User $user, array $data): void
    {
        $user->update($data);
    }
}