<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'SubscriptionPackage'
 *
 * @property integer $id
 * @property integer $grade_id
 * @property integer $price
 * @property integer $duration
 * @property string $title
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SubscriptionPackage whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SubscriptionPackage whereId($value)
 */
class SubscriptionPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'duration', 
        'price',
        'title',
        'grade_id'
    ];
}
