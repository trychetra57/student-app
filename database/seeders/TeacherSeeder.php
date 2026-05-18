<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        Teacher::insert([
            [
                'name'          => 'Sophea Pich',
                'email'         => 'sophea@school.edu',
                'phone'         => '012 345 678',
                'subject'       => 'Mathematics',
                'department'    => 'Science',
                'qualification' => "Master's in Math",
                'joined_date'   => '2019-09-01',
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Dara Meas',
                'email'         => 'dara@school.edu',
                'phone'         => '015 987 654',
                'subject'       => 'English',
                'department'    => 'Language',
                'qualification' => 'B.Ed. English',
                'joined_date'   => '2021-03-15',
                'status'        => 'active',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'Chenda Ly',
                'email'         => 'chenda@school.edu',
                'phone'         => null,
                'subject'       => 'Physics',
                'department'    => 'Science',
                'qualification' => 'B.Sc. Physics',
                'joined_date'   => '2020-08-10',
                'status'        => 'on_leave',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
