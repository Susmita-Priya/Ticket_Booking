<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use  HasFactory;

    protected $fillable = [
        'user_id',
        'plane_id',
        'passenger_name',
        'passenger_age',
        'passport',
    ];
}
