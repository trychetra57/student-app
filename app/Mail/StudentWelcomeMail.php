<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public Student $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->subject('Welcome to Fantastic School, '.$this->student->name.'!')
                    ->view('emails.student_welcome');
    }
}
