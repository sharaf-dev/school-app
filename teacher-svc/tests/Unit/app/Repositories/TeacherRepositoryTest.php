<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;

class TeacherRepositoryTest extends TestCase
{
    public function test_GetTeacher_returns_Teacher()
    {
        $expected = Teacher::factory()->make();
        $teacherRepo = $this->createTeacherRepository($expected);

        $result = $teacherRepo->getTeacher([]);
        $this->assertEquals($expected, $result);
    }

    public function test_GetTeacher_returns_null()
    {
        $teacherRepo = $this->createTeacherRepository();

        $result = $teacherRepo->getTeacher([]);
        $this->assertNull($result);
    }

    public function test_CheckPassword_returns_true()
    {
        $expected = Teacher::factory()->make();
        $teacherRepo = $this->createTeacherRepository($expected);

        $result = $teacherRepo->checkPassword($expected, 'password');
        $this->assertTrue($result);
    }

    public function test_CheckPassword_returns_false()
    {
        $expected = Teacher::factory()->make();
        $teacherRepo = $this->createTeacherRepository($expected);

        $result = $teacherRepo->checkPassword($expected, 'incorrect password');
        $this->assertFalse($result);
    }

    private function createTeacherRepository(Teacher $expected = null) : TeacherRepository
    {
        $teacher = $this->mockTeacher($expected);
        return new TeacherRepository($teacher);
    }

    private function mockTeacher(Teacher $teacher = null) : Teacher
    {
        return $this->mock(Teacher::class, function ($mock) use ($teacher) {
            $mock->shouldReceive('firstWhere')->andReturn($teacher);
        });
    }
}
