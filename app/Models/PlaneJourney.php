<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaneJourney extends Model
{
    use HasFactory;
    protected $fillable = [
        'plane_id',
        'journey_types_id',
        'from_country_id',
        'start_location_id',
        'to_country_id',
        'end_location_id',
        'start_date',
        'end_date',
        'total_seats',
        'available_seats',
        'published_status'
    ];

    public function plane()
    {
        return $this->belongsTo(Plane::class);
    }
}
