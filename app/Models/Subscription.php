<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An Eloquent Model: 'Subscription'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $subscription_package_id
 * @property string $expire_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereSubscriptionPackageId($value)
 */
class Subscription extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'subscription_package_id',
        'expire_at'
    ];

    
    public function subscription_package(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
