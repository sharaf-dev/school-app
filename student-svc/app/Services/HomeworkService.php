<?php

namespace App\Services;

use App\Repositories\IHomeworkRepository;
use App\DTOs\HomeworkData;
use Illuminate\Support\Arr;

class HomeworkService implements IHomeworkService
{
    public function __construct(public IHomeworkRepository $repo) {}

    /**
     * Get homeworks
     * @param array $studentId
     *
     * @return array
     */
    public function getHomeworks(int $studentId) : array
    {
        return $this->repo->getHomeworks($studentId);
    }

    /**
     * Submit homework
     * @param HomeworkData $homeworkData
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function submitHomework(HomeworkData $homeworkData) : void
    {
        $response = $this->repo->submitHomework($homeworkData);
        throw_unless(
            $response['status'],
            \InvalidArgumentException::class,
            Arr::get($response, 'data.message'),
        );
    }
}

