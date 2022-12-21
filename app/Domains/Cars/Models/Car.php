<?php

namespace App\Domains\Cars\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'year',
        'color',
        'license_plate',
        'km'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function (Car $car) {
            return $car->id = (string)Uuid::uuid4();
        });
    }
}
