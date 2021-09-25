<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;
use App\Services\TeacherService;
use App\DTOs\TeacherData;
use App\Exceptions\TeacherNotFoundException;

class TeacherServiceTest extends TestCase
{
    public function test_Authentication_returns_Teacher()
    {
        $expected = Teacher::Factory()->make();
        $teacherSvc = $this->createTeacherService($expected);
        $teacherData = new TeacherData();
        $teacherData->email = $expected->email;
        $teacherData->password = "password";
        
        $result = $teacherSvc->authenticate($teacherData);
        $this->assertEquals($expected, $result);
    }

    public function test_Authentication_throws_TeacherNotFoundException()
    {
        $teacherSvc = $this->createTeacherService();
        $teacherData = new TeacherData();
        $teacherData->email = "";
        $teacherData->password = "";
        
        $this->expectException(TeacherNotFoundException::class);
        $result = $teacherSvc->authenticate($teacherData);
    }

    private function createTeacherService(Teacher $teacher = null)
    {
        $teacherRepo = $this->mockTeacherRepository($teacher);
        return new TeacherService($teacherRepo);
    }

    private function mockTeacherRepository(Teacher $teacher = null) : TeacherRepository
    {
        return $this->mock(TeacherRepository::class, function ($mock) use ($teacher) {
            $mock->shouldReceive('getTeacher')->andReturn($teacher);
            $mock->shouldReceive('checkPassword')->andReturn($teacher!= null);
        });
    }
}
