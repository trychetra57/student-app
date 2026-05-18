<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'department',
        'address', 'date_of_birth', 'joined_date',
        'qualification', 'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joined_date'   => 'date',
    ];

    /**
     * Calculate age from date_of_birth.
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Years of experience based on joined_date.
     */
    public function getExperienceYearsAttribute(): ?int
    {
        return $this->joined_date ? $this->joined_date->diffInYears(now()) : null;
    }
}
