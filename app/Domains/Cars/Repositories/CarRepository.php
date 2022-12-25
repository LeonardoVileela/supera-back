<?php

namespace App\Domains\Cars\Repositories;

use App\Domains\Cars\Models\Car;
use Illuminate\Database\Eloquent\Collection;

class CarRepository
{
    public function getAll($id): Collection
    {
        return Car::all()->where('user_id', $id)->sortBy([
            ['created_at', 'desc']
        ]);
    }

    public function getAllNextMaintenance($id): Collection
    {
        return Car::all()->where('user_id', $id)
            ->whereBetween('maintenance_date', [now(), now()->addDays(30)])
            ->sortBy([
                ['next_maintenance_date', 'desc']
            ]);
    }

    public function getCarsWithMaintenance($id): Collection
    {
        return Car::with(['maintenance'])->where('user_id', $id)->get();
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
