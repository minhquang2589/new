<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    protected $table = 'sizechart';
    protected $fillable = [
        'cate_name',
        'image_url',
    ];
}
