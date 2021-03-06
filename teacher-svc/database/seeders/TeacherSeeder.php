<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = Teacher::find(1);
        if (!$teacher)
        {
            Teacher::factory(1)->create();
        }
    }
}
