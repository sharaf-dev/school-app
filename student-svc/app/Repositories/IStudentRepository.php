<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Collection;

interface IStudentRepository
{
    public function getStudent(array $options) : ?Student;

    public function checkPassword(Student $student, string $password) : bool;

    public function getStudents(array $studentIds) : Collection;
}
