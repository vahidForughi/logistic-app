<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    const CAR_BRANDS = [
        'BMW' => 1,
        'BENZ' => 2,
        'HONDA' => 3
    ];
}
