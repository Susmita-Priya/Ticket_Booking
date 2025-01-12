<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeatBooking extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable=[
        'company_id',
        'vehicle_id',
        'seat_id',
        'seat_no',
        'booking_date',
        'payment_amount',
        'passenger_name',
        'passenger_phone',
    ];
}
