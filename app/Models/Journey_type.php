<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journey_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];
}
