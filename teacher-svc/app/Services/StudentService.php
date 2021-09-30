<?php

namespace App\Services;

use App\Repositories\IStudentRepository;
use App\Exceptions\StudentNotFoundException;

class StudentService implements IStudentService
{
    public function __construct(public IStudentRepository $repo) {}


    /**
     * Validate whether student exist
     * @param array $studentId
     *
     * @return void
     */
    public function validateStudent(int $studentId) : void
    {
        $this->validateStudents([$studentId]); 
    }

    /**
     * Validate whether students exist
     * @param array $studentIds
     *
     * @return void
     */
    public function validateStudents(array $studentIds) : void
    {
        if (!empty($studentIds))
        {
            $students = $this->repo->getStudents($studentIds); 
            $this->checkStudentExist($studentIds, $students);
        }
    }

    private function checkStudentExist(array $studentIds, array $students) : void
    {
        $dbIds = [];
        foreach ($students as $student) 
        {
            $dbIds[] = $student['id'];
        }

        $invalidStudents = array_merge(array_diff($studentIds, $dbIds));

        throw_unless(
            empty($invalidStudents),
            StudentNotFoundException::class,
            'Students not found',
            [ 'students' => $invalidStudents ]
        );
    }
}
