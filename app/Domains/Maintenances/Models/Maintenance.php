<?php

namespace App\Domains\Maintenances\Models;

use App\Domains\Cars\Models\Car;
use App\Domains\Users\Models\User;
use App\Traits\hasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'maintenance_date',
        'next_maintenance_date',
        'car_id'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function (Maintenance $maintenance) {
            return $maintenance->id = (string)Uuid::uuid4();
        });
    }

    public function car(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
