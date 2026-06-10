<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\Student::all();
        $classes = \App\Models\SchoolClass::all();

        if ($classes->isEmpty()) {
            $teacher = \App\Models\Teacher::first();
            $classes = collect([
                \App\Models\SchoolClass::create(['name' => 'Math 101', 'room_number' => '101A', 'teacher_id' => $teacher?->id, 'capacity' => 30, 'status' => 'active']),
                \App\Models\SchoolClass::create(['name' => 'English 101', 'room_number' => '102B', 'teacher_id' => $teacher?->id, 'capacity' => 25, 'status' => 'active']),
                \App\Models\SchoolClass::create(['name' => 'Physics 101', 'room_number' => '201C', 'teacher_id' => $teacher?->id, 'capacity' => 20, 'status' => 'active']),
            ]);
        }

        if ($students->isEmpty()) {
            $students = \App\Models\Student::factory(10)->create();
        }

        // Enroll students in classes
        foreach ($students as $student) {
            // Enroll in 2 random classes
            $randomClasses = $classes->random(min(2, $classes->count()));
            foreach ($randomClasses as $class) {
                $class->students()->syncWithoutDetaching([$student->id]);

                // Create attendance for the last 5 days
                for ($i = 0; $i < 5; $i++) {
                    $date = now()->subDays($i)->toDateString();
                    $status = collect(['present', 'present', 'present', 'present', 'late', 'absent'])->random();
                    
                    \App\Models\Attendance::updateOrCreate(
                        [
                            'school_class_id' => $class->id,
                            'student_id' => $student->id,
                            'attendance_date' => $date,
                        ],
                        [
                            'status' => $status,
                            'remarks' => $status !== 'present' ? 'Seeded status' : null,
                        ]
                    );
                }

                // Create Grades (Quiz, Midterm, Final)
                foreach (['Quiz', 'Midterm', 'Final'] as $exam) {
                    \App\Models\Grade::updateOrCreate(
                        [
                            'school_class_id' => $class->id,
                            'student_id' => $student->id,
                            'exam_type' => $exam,
                        ],
                        [
                            'score' => rand(65, 99) + (rand(0, 99) / 100),
                            'remarks' => 'Seeded exam grade',
                        ]
                    );
                }
            }
        }
    }
}
