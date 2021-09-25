<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements ITeacherRepository
{
    public function __construct(public Teacher $teacher) {}

    /**
     * Get teacher
     * @param array $options
     *
     * @return Teacher $teacher
     */
    public function getTeacher(array $options) : ?Teacher
    {
        return $this->teacher->firstWhere($options);
    }

    /**
     * Check hashed password
     * @param Teacher $teacher
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(Teacher $teacher, string $password) : bool
    {
        return Hash::check($password, $teacher->password);
    }
}
