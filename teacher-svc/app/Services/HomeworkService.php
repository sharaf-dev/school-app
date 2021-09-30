<?php

namespace App\Services;

use App\DTOs\HomeworkData;
use App\DTOs\StudentHomeworkData;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\Repositories\IHomeworkRepository;
use App\Exceptions\HomeworkNotFoundException;
use App\Exceptions\ArgumentException;

class HomeworkService implements IHomeworkService
{
    public function __construct(public IHomeworkRepository $repo) {}

    /**
     * Create homework
     * @param Homework $homework
     *
     * @return Homework
     */
    public function createHomework(HomeworkData $homeworkData) : Homework
    {
        return $this->repo->createHomework($homeworkData);
    }

    /**
     * Assign homework to students
     * @param HomeworkData $homeworkData
     *
     * @return bool
     * @throws ArgumentException
     */
    public function assignHomework(HomeworkData $homeworkData) : bool
    {
        throw_if(empty($homeworkData->assignees), ArgumentException::class, 'Invalid Assignee');

        $assignedStudents = [];
        foreach ($homeworkData->assignees as $assignee)
        {
            $homework = $this->repo->getStudentHomework($assignee, $homeworkData->id);
            if ($homework)
            {
                $assignedStudents[] = $assignee;
            }
        }

        throw_if(
            !empty($assignedStudents),
            ArgumentException::class,
            'Homework already assigned',
            [
                'student_ids' => $assignedStudents
            ]
        );

        return $this->repo->assignHomework($homeworkData); 
    }

    /**
     * Get homework
     * @param int homeworkId
     *
     * @return Homework
     * @throws HomeworkNotFoundException
     */
    public function getHomework(int $homeworkId) : Homework
    {
        $homework = $this->repo->getHomework($homeworkId);
        throw_unless($homework, HomeworkNotFoundException::class);

        return $homework;
    }

    /**
     * Get homeworks
     * @param int studentId
     *
     * @return array
     */
    public function getHomeworks(int $studentId) : array
    {
        $homeworks = [];
        $studentHomeworks = $this->repo->getHomeworks($studentId);
        foreach ($studentHomeworks as $studentHomework)
        {
            $homeworks[] = $studentHomework->homework;
        }
        return $homeworks;
    }

    /**
     * Submit homeworks
     * @param StudentHomeworkData $homeworkData
     *
     * @return void
     * @throws ArgumentException
     */
    public function submitHomework(StudentHomeworkData $homeworkData) : void
    {
        $homework = $this->repo->getStudentHomework($homeworkData->studentId, $homeworkData->homeworkId);
        throw_if(!$homework, HomeworkNotFoundException::class);
        throw_if($homework->isSubmitted(), ArgumentException::class ,'Homework already submitted');

        $status = $this->repo->submitHomework($homeworkData);
        throw_unless($status, ArgumentException::class, 'Homework submission failed');
    }
}
