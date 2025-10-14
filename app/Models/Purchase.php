<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An Eloquent Model: 'Purchase'
 *
 * @property integer $id
 * @property string $user_id
 * @property string $course_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Purchase whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Purchase whereCourseId($value)
 */
class Purchase extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'course_id',
        'paid_amount',
        'paid_at'
    ];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
