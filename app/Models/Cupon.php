<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Cupon extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'company_id',
        'cupon_code',
        'start_date',
        'end_date',
        'minimum_expend',
        'discount_amount',
    ];
}
