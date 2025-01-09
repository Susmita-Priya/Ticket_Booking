<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable=[
        'company_id',
        'owner_id',
        'type_id',
        'name',
        'vehicle_no',
        'engin_no',
        'chest_no',
        'total_seat',
        'amenities_id',
        'document',
        'is_booked',
        'status',

    ];

    public function owner(){
        return $this->belongsTo(Owner::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }

}
