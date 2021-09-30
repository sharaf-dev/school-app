<?php

namespace App\Services;

use App\DTOs\HomeworkData;

interface IHomeworkService
{
    public function getHomeworks(int $studentId) : array;

    public function submitHomework(HomeworkData $homeworkData) : void;
}

