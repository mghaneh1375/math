<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTag extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $fillable = [
        'course_id',
        'value'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
