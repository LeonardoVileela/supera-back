<?php

namespace App\Domains\Cars\Services;


use App\Domains\Cars\Repositories\CarRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CarService
{

    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function saveCar(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'model' => 'required|string|max:255',
                'year' => 'required',
                'color' => 'required|string|max:255',
                'license_plate' => 'required|string|unique:cars',
                'km' => 'required'
            ]);
        } catch (\Exception $e) {
            throw new HttpResponseException(response()->json(['message' => 'invalid car'], 400));
        }

        $car = $this->carRepository->create([
            'model' => $validatedData['model'],
            'year' => $validatedData['year'],
            'color' => $validatedData['color'],
            'license_plate' => $validatedData['license_plate'],
            'km' => $validatedData['km'],
            'user_id' => $request->user()->id
        ]);

        return response()->json($car, 201);
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

        if($this->carRepository->update($id, $car)){
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

    public function closeToMaintenanceDate(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->carRepository->getCloseToMaintenanceDate($request->user()->id), 200);
    }

}
