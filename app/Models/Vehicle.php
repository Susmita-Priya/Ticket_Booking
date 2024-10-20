<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'category_id',
        'type_id',
        'amenities_ids',
        'engin_no',
        'total_seat',
        'status',
    ];

    protected $casts = [
        'amenities_ids' => 'array',
    ];

}
