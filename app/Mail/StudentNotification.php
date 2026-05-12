<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $action;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, string $action, $user = null)
    {
        $this->student = $student;
        $this->action = $action;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $actionText = ucfirst($this->action);
        return new Envelope(
            subject: "Student {$actionText}: {$this->student->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.student-notification',
            with: [
                'student' => $this->student,
                'action' => $this->action,
                'user' => $this->user,
            ],
        );
    }
}
