<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Student;

class BulkDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create an admin user for authentication
        $this->admin = User::factory()->create([
            'role' => 'admin',
            // Password will be auto‑hashed via model casts
            'password' => 'password',
        ]);
    }

    /** @test */
    public function it_soft_deletes_selected_students()
    {
        $this->actingAs($this->admin);

        // Create a few students
        $students = Student::factory()->count(3)->create();
        $ids = $students->pluck('id')->toArray();

        $response = $this->delete(route('students.bulk.delete'), [
            'student_ids' => $ids,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        foreach ($students as $student) {
            $this->assertSoftDeleted('students', ['id' => $student->id]);
        }
    }

    /** @test */
    public function it_permanently_deletes_selected_students()
    {
        $this->actingAs($this->admin);

        $students = Student::factory()->count(2)->create();
        $ids = $students->pluck('id')->toArray();

        $response = $this->delete(route('students.bulk.force-delete'), [
            'student_ids' => $ids,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        foreach ($students as $student) {
            $this->assertDatabaseMissing('students', ['id' => $student->id]);
        }
    }
}
