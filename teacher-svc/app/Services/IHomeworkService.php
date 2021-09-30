<?php

namespace App\Services;

use App\DTOs\HomeworkData;
use App\Models\Homework;
use App\DTOs\StudentHomeworkData;

interface IHomeworkService
{
    public function createHomework(HomeworkData $homeworkData) : Homework;

    public function assignHomework(HomeworkData $homeworkData) : bool;

    public function getHomework(int $homeworkId) : Homework;

    public function getHomeworks(int $homeworkId) : array;

    public function submitHomework(StudentHomeworkData $homeworkData) : void;
}

