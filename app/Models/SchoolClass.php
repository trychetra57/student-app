<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'room_number',
        'teacher_id',
        'capacity',
        'status',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'school_class_id', 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'school_class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'school_class_id');
    }
}
