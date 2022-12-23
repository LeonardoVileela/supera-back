<?php

namespace App\Domains\Maintenances\Services;


use App\Domains\Cars\Repositories\CarRepository;
use App\Domains\Maintenances\Repositories\MaintenanceRepository;
use DateTime;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class MaintenanceService
{

    private $maintenanceRepository;

    private $carRepository;

    public function __construct(MaintenanceRepository $maintenanceRepository, CarRepository $carRepository)
    {
        $this->maintenanceRepository = $maintenanceRepository;
        $this->carRepository = $carRepository;
    }

    public function saveMaintenance(Request $request, $id): \Illuminate\Http\JsonResponse
    {

        $car = $this->carRepository->getById($id);
        try {
            $validatedData = $request->validate([
                'maintenance_date' => 'required',
                'km' => 'required'
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => 'invalid car'], 400));
        }

        $nextDate = $this->calcNextMaintenance($id, $validatedData['maintenance_date']);


        $maintenance = $this->maintenanceRepository->create([
            'maintenance_date' => $validatedData['maintenance_date'],
            'km' => $validatedData['km'],
            'car_id' => $id,
        ]);

        $car->next_maintenance_date = $nextDate;
        $car->km = $validatedData['km'];
        $car->update();

        return response()->json($maintenance, 201);
    }

    public function updateCar(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'model' => 'required|string|max:255',
                'year' => 'required',
                'color' => 'required|string|max:255',
                'license_plate' => 'required|string',
                'km' => 'required'
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => 'invalid car'], 400));
        }

        $car['model'] = $validatedData['model'];
        $car['year'] = $validatedData['year'];
        $car['color'] = $validatedData['color'];
        $car['license_plate'] = $validatedData['license_plate'];
        $car['km'] = $validatedData['km'];

        if ($this->carRepository->update($id, $car)) {
            return response()->json();
        }

        throw new HttpResponseException(response()->json(['message' => 'invalid car'], 400));

    }

    public function deleteCar($id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->carRepository->getById($id);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => 'invalid id'], 400));
        }
        $this->carRepository->delete($id);
        return response()->json();
    }

    public function all(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->carRepository->getAll($request->user()->id), 200);
    }

    public function carsWithMaintenance(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->carRepository->getCarsWithMaintenance($request->user()->id), 200);
    }

    public function calcNextMaintenance($id, $validDate)
    {
        if (gettype($validDate) == 'string') {
            $car = $this->carRepository->getById($id);
            $year = $car->year . "-01-01";
            $date1 = new DateTime($year);
            $date2 = new DateTime($validDate);
            $interval = $date2->diff($date1)->format('%a');

            $media = $car->km / $interval;
            $days = 10000 / $media;

            if ($days > 160) {
                return 160;
            }

            return date('Y-m-d', strtotime($validDate . ' + ' . $days . ' day'));
        }

        $car = $this->carRepository->getById($id);
        $year = $car->year . "-01-01";
        $date1 = new DateTime($year);
        $date2 = $validDate;
        $interval = $date2->diff($date1)->format('%a');

        $media = $car->km / $interval;
        $days = 10000 / $media;
        $days = (int)round($days);

        if ($days > 160) {
            return 160;
        }

        return date('Y-m-d', strtotime($validDate->format('Y-m-d') . ' + ' . $days . ' day'));
    }


}
