<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * An Eloquent Model: 'OffCode'
 *
 * @property integer $id
 * @property string $code
 * @property string $type
 * @property string $expire_at
 * @property integer $value
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OffCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OffCode whereCode($value)
 */
class OffCode extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'expire_at',
        'type',
        'value',
        'code'
    ];
}
