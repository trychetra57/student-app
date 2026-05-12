<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'file_name', 'file_path', 'file_type', 'document_type', 'uploaded_by'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
