<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Models\Student;
use App\Repositories\StudentRepository;
use Illuminate\Support\Collection;

class StudentRepositoryTest extends TestCase
{
    public function test_GetStudent_returns_user()
    {
        $expected = Student::factory()->make();
        $studentRepo = $this->createStudentRepository($expected);

        $result = $studentRepo->getStudent([]);
        $this->assertEquals($expected, $result);
    }

    public function test_GetStudent_returns_null()
    {
        $studentRepo = $this->createStudentRepository();

        $result = $studentRepo->getStudent([]);
        $this->assertNull($result);
    }

    public function test_CheckPassword_returns_true()
    {
        $expected = Student::factory()->make();
        $studentRepo = $this->createStudentRepository($expected);

        $result = $studentRepo->checkPassword($expected, 'password');
        $this->assertTrue($result);
    }

    public function test_CheckPassword_returns_false()
    {
        $expected = Student::factory()->make();
        $studentRepo = $this->createStudentRepository($expected);

        $result = $studentRepo->checkPassword($expected, 'incorrect password');
        $this->assertFalse($result);
    }

    public function test_getStudents_returns_collection()
    {
        $expected = new Collection();
        $studentRepo = $this->createStudentRepository();
        $result = $studentRepo->getStudents([]);
        $this->assertEquals($expected, $result);
    }

    private function createStudentRepository(Student $expected = null)
    {
        $student = $this->mockStudent($expected);
        return new StudentRepository($student);
    }

    private function mockStudent(Student $student = null) : Student
    {
        return $this->mock(Student::class, function ($mock) use ($student) {
            $mock->shouldReceive('firstWhere')->andReturn($student);
            $mock->shouldReceive('whereIn->get')->andReturn(new Collection());
        });
    }
}
