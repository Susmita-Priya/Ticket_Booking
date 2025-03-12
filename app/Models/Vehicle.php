<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'owner_id',
        'type_id',
        'category',
        'name',
        'vehicle_no',
        'engin_no',
        'chest_no',
        'total_seat',
        'amenities_id',
        'document',
        'is_booked',
        'current_location_id',
        'status',
    ];

    public function company(){
        return $this->belongsTo(User::class);
    }

    public function owner(){
        return $this->belongsTo(Employee::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
