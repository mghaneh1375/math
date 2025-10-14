<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class CourseSession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'chapter',
        'duration',
        'description',
        'file',
        'chunked_at',
        'should_chunk',
        'visibility',
        'course_id'
    ];

    
    public function attaches(): HasMany
    {
        return $this->hasMany(CourseSessionAttach::class);
    }
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function seo_tags(): HasMany
    {
        return $this->hasMany(SessionSeoTag::class, 'session_id', 'id');
    }

    public function scopeReady(Builder $query): void
    {
        $query->where('visibility', true)
            ->where(function ($query) {
                $query->where('should_chunk', false)
                    ->orWhere(function ($query) {
                        $query->where('should_chunk', true)
                                ->whereNotNull('chunked_at');
                    });
            });
    }
}
