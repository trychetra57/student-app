<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image_path',
        'target_url',
        'is_active',
        'order_index',
        'clicks',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
        'clicks' => 'integer',
    ];
}
