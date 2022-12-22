<?php

namespace App\Domains\Cars\Http\Controllers;

use App\Domains\Cars\Services\CarService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CarController extends Controller
{

    private $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function all(Request $request, $id): JsonResponse
    {
        return $this->carService->all($request);
    }

    public function closeToMaintenanceDate(Request $request): JsonResponse
    {
        return $this->carService->closeToMaintenanceDate($request);
    }

    public function save(Request $request): JsonResponse
    {
        return $this->carService->saveCar($request);
    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id): JsonResponse
    {
        return $this->carService->updateCar($request, $id);
    }

    public function delete($id): JsonResponse
    {
        return $this->carService->deleteCar($id);
    }
}
