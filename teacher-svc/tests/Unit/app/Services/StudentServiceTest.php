<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Services\StudentService;
use App\Repositories\StudentRepository;
use App\Exceptions\StudentNotFoundException;

class StudentServiceTest extends TestCase
{
    public function test_validate_students()
    {
        $students = [
            ['id' => 1]
        ];
        $studentSvc = $this->createStudentService($students);
        $studentSvc->validateStudent(1);
    }

    public function test_validate_students_throws_exception()
    {
        $students = [];
        $studentSvc = $this->createStudentService($students);

        $this->expectException(StudentNotFoundException::class);
        $studentSvc->validateStudent(1);
    }

    private function createStudentService(array $students = []) : StudentService
    {
        $studentRepo = $this->mockStudentRepository($students);
        return new StudentService($studentRepo);
    }

    private function mockStudentRepository(array $students = []) : StudentRepository
    {
        return $this->mock(StudentRepository::class, function ($mock) use ($students) {
                $mock->shouldReceive('getStudents')->andReturn($students);
            }
        );
    }
}
