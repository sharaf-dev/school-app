<?php

namespace App\Services;

use App\DTOs\StudentData;
use App\Models\Student;
use Illuminate\Support\Collection;

interface IStudentService
{
    public function authenticate(StudentData $studentData) : Student;

    public function createToken(Student $student) : string;

    public function getStudents(array $studentIds) : Collection;
}
