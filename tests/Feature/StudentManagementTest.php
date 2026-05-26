<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    protected function createTestUser(): User
    {
        return User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);
    }

    public function test_home_page_displays_students(): void
    {
        $this->actingAs($this->createTestUser());

        Student::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '555-1234',
        ]);

        $response = $this->get(route('students.index'));

        $response->assertStatus(200);
        $response->assertSee('Jane Doe');
        $response->assertSee('jane@example.com');
    }

    public function test_student_can_be_created(): void
    {
        $this->actingAs($this->createTestUser());

        $response = $this->post(route('students.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '555-6789',
        ]);

        $response->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_student_detail_page_shows_information(): void
    {
        $this->actingAs($this->createTestUser());

        $student = Student::create([
            'name' => 'Mia Lee',
            'email' => 'mia@example.com',
            'phone' => '555-9876',
        ]);

        $response = $this->get(route('students.show', $student));

        $response->assertStatus(200);
        $response->assertSee('Student Details');
        $response->assertSee('Mia Lee');
        $response->assertSee('mia@example.com');
    }
}
