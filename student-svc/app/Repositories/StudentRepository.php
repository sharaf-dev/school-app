<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentRepository implements IStudentRepository
{
    public function __construct(public Student $student) {}

    /**
     * Get student
     * @param array $options
     *
     * @return Student $student
     */
    public function getStudent(array $options) : ?Student
    {
        return $this->student->firstWhere($options);
    }

    /**
     * Check hashed password
     * @param Student $student
     * @param string $password
     *
     * @return bool
     */
    public function checkPassword(Student $student, string $password) : bool
    {
        return Hash::check($password, $student->password);
    }
}
