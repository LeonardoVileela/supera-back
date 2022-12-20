<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getAll(): Collection
    {
        return User::all();
    }

    public function getById($id): User
    {
        return User::findOrFail($id);
    }

    public function getByEmail($email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function delete($id): int
    {
        return User::destroy($id);
    }

    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    public function update($id, array $attributes): bool
    {
        return User::whereId($id)->update($attributes);
    }
}
