<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An Eloquent Model: 'Lesson'
 *
 * @property integer $id
 * @property string $name
 * @property integer $grade_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lesson whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Lesson whereName($value)
 */
class Lesson extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'grade_id'
    ];

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
