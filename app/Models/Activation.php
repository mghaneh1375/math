<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An Eloquent Model: 'Activation'
 *
 * @property integer $id
 * @property string $token
 * @property string $code
 * @property integer $user_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activation whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activation whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activation whereUserId($value)
 */
class Activation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'expire_at',
        'code',
        'token'
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
