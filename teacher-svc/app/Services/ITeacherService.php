<?php

namespace App\Services;

use App\DTOs\TeacherData;
use App\Models\Teacher;

interface ITeacherService
{
    public function authenticate(TeacherData $teacherData) : Teacher;

    public function createToken(Teacher $teacher) : string;
}
