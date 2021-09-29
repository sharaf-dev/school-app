<?php

namespace App\Services;

use App\Repositories\IHomeworkRepository;
use Illuminate\Support\Collection;

class HomeworkService implements IHomeworkService
{
    public function __construct(public IHomeworkRepository $repo) {}

    /**
     * Get homeworks
     * @param array $studentId
     *
     * @return Illuminate\Support\Collection
     */
    public function getHomeworks(int $studentId) : array
    {
        return $this->repo->getHomeworks($studentId);
    }
}

