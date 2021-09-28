<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

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

    /**
     * Get students
     * @param array $studentIds
     *
     * @return Illuminate\Support\Collection
     */
    public function getStudents(array $studentIds) : Collection
    {
        return $this->student->whereIn('id', $studentIds)->get();
    }
}
