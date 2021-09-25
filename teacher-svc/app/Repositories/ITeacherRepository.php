<?php

namespace App\Repositories;

use App\Models\Teacher;

interface ITeacherRepository
{
    public function getTeacher(array $options) : ?Teacher;

    public function checkPassword(Teacher $teacher, string $password) : bool;
}
