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

    public function getAllRecent($id): \Illuminate\Support\Collection
    {
        return DB::table('maintenances')->whereBetween('maintenance_date', [now(), now()->addDays(30)])
            ->join('cars', 'maintenances.car_id', '=', 'cars.id')
            ->where('user_id', $id)->get();

            /*Maintenance::all()
            ->whereBetween('maintenance_date', [now(), now()->addDays(30)])
            ->join('cars', 'maintenances.car_id', '=', 'cars.id');*/

               /* ->sortBy([
            ['maintenances.created_at', 'desc']
        ]);*/
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
