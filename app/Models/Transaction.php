<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'amount',
        'offer_id',
        'course_id',
        'subscription_package_id',
        'ref_code',
        'tracking_code',
        'status'
    ];
}
