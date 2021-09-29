<?php

namespace App\Services;

use App\DTOs\StudentData;

interface IHomeworkService
{
    public function getHomeworks(int $studentId) : array;
}

