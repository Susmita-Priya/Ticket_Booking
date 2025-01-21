<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'trip_id',
        'vehicle_id',
        'seat_id',
        'seat_no',
        'booking_date',
        'payment_amount',
        'passenger_name',
        'passenger_phone',
    ];
}
