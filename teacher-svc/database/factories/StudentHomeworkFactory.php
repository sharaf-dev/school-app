<?php

namespace Database\Factories;

use App\Models\StudentHomework;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentHomeworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentHomework::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link' => 'dummy link',
            'submitted_at' => '2000-01-01 00:00:00',
            'homework_id' => 1,
            'student_id' => 1,
            'status' => StudentHomework::STATUS_NEW
        ];
    }
}
