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
        'route_no',
        'counters_id',
        'route_manager_id',
        'checkers_id',
        'document',
        'status',
    ];

    public function routeManager()
    {
        return $this->belongsTo(RouteManager::class, 'route_manager_id');
    }

}
