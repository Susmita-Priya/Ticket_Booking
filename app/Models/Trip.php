<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'route_id',
        'vehicle_id',
        'driver_id',
        'helper_id',
        'supervisor_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'total_route_cost',
        'ticket_price',
        'trip_status',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
