<?php

namespace App\Domains\Cars\Models;


use App\Domains\Maintenances\Models\Maintenance;
use App\Domains\Users\Models\User;
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
        'km',
        'next_maintenance_date',
        'user_id'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function (Car $car) {
            return $car->id = (string)Uuid::uuid4();
        });

        static::deleting(function(Car $car) {
            $car->maintenance()->delete();
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function maintenance(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Maintenance::class);
    }
}
