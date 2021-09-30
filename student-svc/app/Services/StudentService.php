<?php

namespace App\Services;

use App\DTOs\StudentData;
use App\Models\Student;
use App\Exceptions\StudentNotFoundException;
use App\Repositories\IStudentRepository;
use Illuminate\Support\Collection;

class StudentService implements IStudentService
{
    public function __construct(public IStudentRepository $repo) {}

    /**
     * Authenticate student by email and Password
     * @param StudentData $studentData
     *
     * @return Student
     * @throws StudentNotFoundException
     */
    public function authenticate(StudentData $studentData) : Student
    {
        $student = $this->repo->getStudent(['email' => $studentData->email]);
        if ($student && $this->repo->checkPassword($student, $studentData->password)) {
            return $student;
        }

        throw new StudentNotFoundException();
    }

    /**
     * Create authentication token
     * @param Student $student
     *
     * @return string
     */
    public function createToken(Student $student) : string
    {
        return $student->createToken($student->student_id)->plainTextToken;
    }

    /**
     * Get students
     * @param array $studentIds
     *
     * @return Illuminate\Support\Collection
     */
    public function getStudents(array $studentIds) : Collection
    {
        return $this->repo->getStudents($studentIds);
    }
}
