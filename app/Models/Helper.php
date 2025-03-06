<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'address',
        'nid',
        'document',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(User::class);
    }

}
