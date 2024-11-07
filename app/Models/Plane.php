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
        'journey_type_id',
        'amenities_ids',
        'country_id',
        'location_id',
        'name',
    ];
}
