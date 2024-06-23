<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookBook extends Model
{
    protected $table = 'lookbook';
    protected $fillable = [
        'title',
        'description',
        'content',
        'status',
    ];
}
