<?php

namespace App\Domains\Maintenances\Repositories;

use App\Domains\Maintenances\Models\Maintenance;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MaintenanceRepository
{
    public function getAll($car_id): Collection
    {
        return Maintenance::all()->where('car_id', $car_id)->sortBy([
            ['created_at', 'desc']
        ]);
    }

    public function getById($id): Maintenance
    {
        return Maintenance::findOrFail($id);
    }

    public function delete($id): int
    {
        return Maintenance::destroy($id);
    }

    public function create(array $attributes): Maintenance
    {
        return Maintenance::create($attributes);
    }

    public function update($id, array $attributes): bool
    {
        return Maintenance::whereId($id)->update($attributes);
    }
}
