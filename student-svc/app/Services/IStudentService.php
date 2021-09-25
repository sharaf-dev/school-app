<?php

namespace App\Services;

use App\DTOs\StudentData;
use App\Models\Student;

interface IStudentService
{
    public function authenticate(StudentData $studentData) : Student;

    public function createToken(Student $student) : string;
}
