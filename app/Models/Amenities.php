<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id',
        'name',
        'short_details',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
