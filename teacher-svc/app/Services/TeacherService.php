<?php

namespace App\Services;

use App\DTOs\TeacherData;
use App\Models\Teacher;
use App\Exceptions\TeacherNotFoundException;
use App\Repositories\ITeacherRepository;

class TeacherService implements ITeacherService
{
    public function __construct(public ITeacherRepository $repo) {}

    /**
     * Authenticate teacher by email and Password
     * @param TeacherData $teacherData
     *
     * @return Teacher
     */
    public function authenticate(TeacherData $teacherData) : Teacher
    {
        $teacher = $this->repo->getTeacher(['email' => $teacherData->email]);
        if ($teacher && $this->repo->checkPassword($teacher, $teacherData->password)) {
            return $teacher;
        }

        throw new TeacherNotFoundException();
    }

    /**
     * Create authentication token
     * @param Teacher $teacher
     *
     * @return string
     */
    public function createToken(Teacher $teacher) : string
    {
        return $teacher->createToken($teacher->teacher_id)->plainTextToken;
    }
}
