<?php

namespace App\Domains\Cars\Repositories;

use App\Domains\Cars\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarRepository
{
    public function getAll(): Collection
    {
        return Car::all();
    }

    public function getById($id): Car
    {
        return Car::findOrFail($id);
    }

    public function delete($id): int
    {
        return Car::destroy($id);
    }

    public function create(array $attributes): Car
    {
        return Car::create($attributes);
    }

    public function update($id, array $attributes): bool
    {
        return Car::whereId($id)->update($attributes);
    }
}
