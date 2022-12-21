<?php

namespace Database\Factories;

use App\Domains\Cars\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class CarsFactory extends Factory
{

    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => (string) Uuid::uuid4(),
            'model' => $this->faker->name(),
            'year' => $this->faker->year,
            'color' => $this->faker->colorName,
            'license_plate' => Str::random(10),
            'km' => $this->faker->randomNumber(5,true),
        ];
    }
}
