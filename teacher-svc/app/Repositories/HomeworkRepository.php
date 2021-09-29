<?php

namespace App\Repositories;

use App\Models\Homework;
use App\Models\StudentHomework;
use App\DTOs\HomeworkData;
use Illuminate\Support\Collection;

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

    /**
     * Get homework
     * @param int homeworkId
     *
     * @return Homework|null
     */
    public function getHomework(int $homeworkId) : ?Homework
    {
        return $this->homework->find($homeworkId);
    }

    /**
     * Get homeworks
     * @param int studentId
     *
     * @return Illuminate\Support\Collection
     */
    public function getHomeworks(int $studentId) : Collection
    {
        return $this->studentHomework->where('student_id', $studentId)
                                     ->where('status', StudentHomework::STATUS_NEW)
                                     ->get();
    }
}
