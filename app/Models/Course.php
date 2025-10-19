<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Query\Builder;

/**
 * An Eloquent Model: 'Course'
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $img
 * @property integer $price
 * @property integer $priority
 * @property bool $visibility
 * @property double $rate
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course whereVisibility($value)
 */
class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'img',
        'rate',
        'priority',
        'visibility'
    ];
    
    public function seo_tags(): HasMany
    {
        return $this->hasMany(CourseSeoTag::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(CourseTag::class);
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, CourseLesson::class, 'course_id', 'id', 'id', 'lesson_id');
    }
    
    public function free_sessions(): HasManyThrough
    {
        return $this->hasManyThrough(CourseSession::class, CourseFreeSession::class, 'course_id', 'id', 'id', 'session_id');
    }
    
    public function sessions(): HasMany
    {
        return $this->hasMany(CourseSession::class);
    }
    
    public function attaches(): HasMany
    {
        return $this->hasMany(CourseAttach::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
    
    public function scopeVisible($query): void
    {
        $query->where('visibility', true);
    }

    public function scopeHasSession($query): void
    {
        $query->has('sessions');
    }
}
