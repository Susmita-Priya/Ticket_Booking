<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'department',
        'name',
        'email',
        'phone',
        'address',
        'document',
        'nid',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }
}
