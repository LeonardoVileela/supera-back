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
            'km' => $validatedData['km']
        ]);

        return response()->json($car, 201);
    }

}
