<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'grade' => $this->faker->randomElement(['9th Grade', '10th Grade', '11th Grade', '12th Grade', 'Class A', 'Class B', 'Class C']),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->dateTimeBetween('-20 years', '-15 years')->format('Y-m-d'),
            'guardian_name' => $this->faker->name(),
            'guardian_phone' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'graduated']),
        ];
    }
}