<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'config';
    
    protected $fillable = [
        'about_me'
    ];
}
