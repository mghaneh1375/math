<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * An Eloquent Model: 'CourseFreeSession'
 *
 * @property integer $id
 * @property integer $course_id
 * @property integer $session_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseFreeSession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseFreeSession whereCourseId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseFreeSession whereSessionId($value)
 */
class CourseFreeSession extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'course_free_previews';
    
    protected $fillable = [
        'course_id',
        'session_id'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CourseSession::class);
    }

}
