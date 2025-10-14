<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseAttach extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'file',
        'title'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
