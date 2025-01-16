<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'start_counter_id',
        'end_counter_id',
        'route_manager_id',
        'checkers_id',
        'document',
        'status',
    ];

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

}
