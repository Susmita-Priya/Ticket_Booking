<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plane_id',
        'company_id',
        'plane_journey_id',
        'passengers_name',
        'passengers_phone',
        'passengers_passport_no',
        'passengers_age',
    ];
}
