<?php

namespace App\Repositories;

interface IStudentRepository
{
    public function getStudents(array $studentIds) : array;
}
