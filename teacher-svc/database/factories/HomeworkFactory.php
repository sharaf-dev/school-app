<?php

namespace Database\Factories;

use App\Models\Homework;
use Illuminate\Database\Eloquent\Factories\Factory;

class HomeworkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Homework::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'dummy title',
            'description' => 'dummy descprtion',
            'teacher_id' => 1,
        ];
    }
}
