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
}
