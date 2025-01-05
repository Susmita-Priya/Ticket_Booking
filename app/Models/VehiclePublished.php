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
        'start_time',
        'end_time',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function startDivision()
    {
        return $this->belongsTo(Division::class, 'start_division_id');
    }

    public function endDivision()
    {
        return $this->belongsTo(Division::class, 'end_division_id');
    }

    public function startDistrict()
    {
        return $this->belongsTo(District::class, 'start_district_id');
    }

    public function endDistrict()
    {
        return $this->belongsTo(District::class, 'end_district_id');
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}
