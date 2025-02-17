<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $fillable = [
        'district_id',
        'name',
        'status',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }
}
