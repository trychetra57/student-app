<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AcademicRecordTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $class;
    protected $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $teacher = Teacher::create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'subject' => 'Math',
        ]);

        $this->class = SchoolClass::create([
            'name' => 'Math 101',
            'teacher_id' => $teacher->id,
            'capacity' => 30,
            'status' => 'active',
        ]);

        $this->student = Student::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
        ]);
    }

    public function test_can_enroll_student_in_class()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('classes.enroll.store', $this->class), [
            'student_ids' => [$this->student->id]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('class_student', [
            'student_id' => $this->student->id,
            'school_class_id' => $this->class->id,
        ]);
    }

    public function test_can_save_attendance_sheet()
    {
        $this->actingAs($this->admin);

        // First enroll student
        $this->class->students()->attach($this->student->id);

        $response = $this->post(route('attendance.store', $this->class), [
            'date' => now()->toDateString(),
            'attendance' => [
                $this->student->id => 'present',
            ],
            'remarks' => [
                $this->student->id => 'On time',
            ],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'school_class_id' => $this->class->id,
            'status' => 'present',
            'remarks' => 'On time',
        ]);
    }

    public function test_can_save_grades()
    {
        $this->actingAs($this->admin);

        // First enroll student
        $this->class->students()->attach($this->student->id);

        $response = $this->post(route('grades.store', $this->class), [
            'grades' => [
                $this->student->id => [
                    'Quiz' => ['score' => 95.0, 'remarks' => ''],
                    'Midterm' => ['score' => 88.5, 'remarks' => ''],
                    'Final' => ['score' => 92.0, 'remarks' => 'Great final exam'],
                ]
            ]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('grades', [
            'student_id' => $this->student->id,
            'school_class_id' => $this->class->id,
            'exam_type' => 'Final',
            'score' => 92.0,
            'remarks' => 'Great final exam',
        ]);
    }

    public function test_can_view_student_transcript()
    {
        $this->actingAs($this->admin);

        // First enroll student and give some grades
        $this->class->students()->attach($this->student->id);
        
        $this->class->grades()->create([
            'student_id' => $this->student->id,
            'exam_type' => 'Final',
            'score' => 85.00,
        ]);

        $response = $this->get(route('students.transcript', $this->student));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Academic Transcript');
        $response->assertSee('Math 101');
    }
}
