<?php

// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_id',
        'amount',
        'status',
        'invoice_pdf',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

