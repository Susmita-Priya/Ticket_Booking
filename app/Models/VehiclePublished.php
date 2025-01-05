<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePublished extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'vehicle_id',
        'start_division_id',
        'end_division_id',
        'start_district_id',
        'end_district_id',
        'journey_date',
        'status',
    ];
}
