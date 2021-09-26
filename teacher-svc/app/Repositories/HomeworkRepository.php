<?php

namespace App\Repositories;

use App\Models\Homework;
use App\Models\StudentHomework;
use App\DTOs\HomeworkData;

class HomeworkRepository implements IHomeworkRepository
{
    public function __construct(
        public Homework $homework,
        public StudentHomework $studentHomework
    ) {}

    /**
     * Create homework
     * @param HomeworkData $homeworkData
     *
     * @return Homework
     */
    public function createHomework(HomeworkData $homeworkData) : Homework
    {
        return $this->homework->create([
            'title' => $homeworkData->title,
            'description' => $homeworkData->description,
            'teacher_id' => $homeworkData->teacherId,
        ]);
    }

    /**
     * Assign homework to students
     * @param Homeworkdata $homeworkData
     *
     * @return bool
     */
    public function assignHomework(HomeworkData $homeworkData) : bool
    {
        $homeworks = [];
        foreach ($homeworkData->assignees as $assignee)
        {
            $homeworks[] = [
                'homework_id' => $homeworkData->id,
                'student_id' => $assignee,
            ];
        }

        return $this->studentHomework->insert($homeworks);
    }
}
