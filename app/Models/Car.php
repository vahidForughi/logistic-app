<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    protected $fillable = ['model', 'brand'];

    const CAR_BRANDS = [
        'BMW' => 1,
        'BENZ' => 2,
        'HONDA' => 3
    ];

    /**
     * Get the user's first name.
     */
    protected function brand(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => array_search($value, Car::CAR_BRANDS),
        );
    }
}
