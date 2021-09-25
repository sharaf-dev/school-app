<?php

namespace App\Repositories;

use App\Models\Student;

interface IStudentRepository
{
    public function getStudent(array $options) : ?Student;

    public function checkPassword(Student $student, string $password) : bool;
}
