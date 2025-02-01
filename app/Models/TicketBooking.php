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

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    
}
