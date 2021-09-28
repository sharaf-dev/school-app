<?php

namespace App\Repositories;

use App\Models\Homework;
use App\DTOs\HomeworkData;

interface IHomeworkRepository
{
    public function createHomework(HomeworkData $homeworkData) : Homework;

    public function assignHomework(HomeworkData $homeworkData) : bool;

    public function getHomework(int $homeworkId) : ?Homework;
}
