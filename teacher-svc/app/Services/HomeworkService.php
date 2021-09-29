<?php

namespace App\Services;

use App\DTOs\HomeworkData;
use App\Models\Homework;
use App\Repositories\IHomeworkRepository;
use App\Exceptions\HomeworkNotFoundException;

class HomeworkService implements IHomeworkService
{
    public function __construct(public IHomeworkRepository $repo) {}

    /**
     * Create homework
     * @param Homework $homework
     * @param int $teachId
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
     */
    public function assignHomework(HomeworkData $homeworkData) : bool
    {
        if (empty($homeworkData->assignees))
        {
            throw new \InvalidArgumentException("Invalid Assignee");
        }
        return $this->repo->assignHomework($homeworkData); 
    }

    /**
     * Get homework
     * @param int homeworkId
     *
     * @return Homework
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
}
