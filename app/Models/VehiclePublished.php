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
        'start_location_id',
        'end_location_id',
        'journey_date',
        'status',
    ];
}
