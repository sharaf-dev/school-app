<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Services\StudentService;
use App\DTOs\StudentData;
use App\Exceptions\StudentNotFoundException;
use Illuminate\Support\Collection;

class StudentServiceTest extends TestCase
{
    public function test_Authentication_returns_Student()
    {
        $expected = Student::Factory()->make();
        $studentSvc = $this->createStudentService($expected);
        $studentData = new StudentData();
        $studentData->email = $expected->email;
        $studentData->password = "password";
        
        $result = $studentSvc->authenticate($studentData);
        $this->assertEquals($expected, $result);
    }

    public function test_Authentication_throws_StudentNotFoundException()
    {
        $studentSvc = $this->createStudentService();
        $studentData = new StudentData();
        $studentData->email = "";
        $studentData->password = "";
        
        $this->expectException(StudentNotFoundException::class);
        $result = $studentSvc->authenticate($studentData);
    }

    public function test_getStudents_returns_collection()
    {
        $expected = new Collection();
        $studentSvc = $this->createStudentService(null, $expected);

        $result = $studentSvc->getStudents([]);
        $this->assertEquals($expected, $result);
    }

    private function createStudentService(Student $student = null, Collection $students = null) : StudentService
    {
        $studentRepo = $this->mockStudentRepository($student, $students);
        return new StudentService($studentRepo);
    }

    private function mockStudentRepository(Student $student = null, Collection $students = null) : StudentRepository
    {
        return $this->mock(StudentRepository::class, function ($mock) use ($student, $students) {
            $mock->shouldReceive('getStudent')->andReturn($student);
            $mock->shouldReceive('checkPassword')->andReturn($student!= null);
            $mock->shouldReceive('getStudents')->andReturn($students);
        });
    }
}
