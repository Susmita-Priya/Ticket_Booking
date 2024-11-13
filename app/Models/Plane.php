<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Plane extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'company_id',
        'plane_name',
        'amenities_id'
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

    public function plane_journeys()
    {
        return $this->hasMany(Plane_journey::class);
    }
}
