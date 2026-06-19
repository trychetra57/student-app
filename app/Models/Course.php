<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category',
        'duration',
        'tuition_fee',
        'status',
        'description',
        'outcomes',
    ];

    protected $casts = [
        'tuition_fee' => 'decimal:2',
    ];
}
