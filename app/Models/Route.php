<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'from_location_id',
        'to_location_id',
        'start_counter_id',
        'end_counter_id',
        'route_manager_id',
        'checkers_id',
        'document',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(Place::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Place::class, 'to_location_id');
    }

    public function routeManager()
    {
        return $this->belongsTo(RouteManager::class, 'route_manager_id');
    }

    public function startCounter()
    {
        return $this->belongsTo(Counter::class, 'start_counter_id');
    }

    public function endCounter()
    {
        return $this->belongsTo(Counter::class, 'end_counter_id');
    }

    public function checkers()
    {
        return $this->belongsTo(Checker::class);
    }

}
