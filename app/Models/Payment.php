<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'total_payment',
        'payment_method',
        'card_number',
        'card_expiry',
        'security_code',
        'banking_type',
        'transaction_id',
    ];
}
