<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * An Eloquent Model: 'CourseSession'
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $chapter
 * @property string $file
 * @property string $chunked_at
 * @property integer $course_id
 * @property bool $visibility
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseSession whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CourseSession whereCourseId($value)
 */
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
        'course_id',
        'available_resolutions',
        'processing_status',
        'master_playlist_path'
    ];

    protected $casts = [
        'available_resolutions' => 'array',
        'chunked_at' => 'datetime',
    ];
    
    // Get the master playlist URL
    public function getMasterPlaylistUrlAttribute()
    {
        if (!$this->master_playlist_path) {
            return null;
        }
        
        return Storage::url(config('video.storage_disk') . '' . $this->master_playlist_path);
    }

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

    public function scopeReady($query): void
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
