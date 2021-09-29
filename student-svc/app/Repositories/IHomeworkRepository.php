<?php

namespace App\Repositories;


interface IHomeworkRepository
{
    public function getHomeworks(int $studentId) : array;
}
