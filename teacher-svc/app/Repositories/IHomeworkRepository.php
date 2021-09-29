<?php

namespace App\Repositories;

use App\Models\Homework;
use App\DTOs\HomeworkData;
use Illuminate\Support\Collection;

interface IHomeworkRepository
{
    public function createHomework(HomeworkData $homeworkData) : Homework;

    public function assignHomework(HomeworkData $homeworkData) : bool;

    public function getHomework(int $homeworkId) : ?Homework;

    public function getHomeworks(int $studentId) : Collection;
}
