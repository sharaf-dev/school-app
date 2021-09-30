<?php

namespace App\Repositories;

use App\DTOs\HomeworkData;

interface IHomeworkRepository
{
    public function getHomeworks(int $studentId) : array;

    public function submitHomework(HomeworkData $homeworkData) : array;
}
