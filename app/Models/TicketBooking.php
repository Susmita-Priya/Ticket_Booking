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
        'seat_data',
        'passenger_name',
        'passenger_phone',
        'travel_date',
        'type',
        'user_id',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

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

    public function payments()
    {
        return $this->hasOne(Payment::class, 'booking_id');
    }

    
}
