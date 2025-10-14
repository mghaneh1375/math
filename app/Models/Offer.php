<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'Offer'
 *
 * @property integer $id
 * @property string $code
 * @property string $type
 * @property string $start_at
 * @property string $expire_at
 * @property integer $grade_id
 * @property integer $lesson_id
 * @property integer $course_id
 * @property integer $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Offer whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Offer whereName($value)
 */
class Offer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_id',
        'lesson_id',
        'grade_id',
        'start_at',
        'expire_at',
        'type',
        'value',
        'code'
    ];
}
