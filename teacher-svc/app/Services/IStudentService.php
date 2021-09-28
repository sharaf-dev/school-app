<?php

namespace App\Services;

interface IStudentService
{
    public function validateStudent(int $studentId) : void;

    public function validateStudents(array $studentIds) : void;
}

