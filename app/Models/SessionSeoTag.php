<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionSeoTag extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'key',
        'value'
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(CourseSession::class);
    }
}
