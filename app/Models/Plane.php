<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Plane extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plane_name',
        'amenities_id'
    ];

    // protected $casts = [
    //     'amenities_id' => 'array',
    // ];



    public function company()
    {
        return $this->belongsTo(User::class);
    }

    public function planejourneys()
    {
        return $this->hasMany(PlaneJourney::class);
    }
}
