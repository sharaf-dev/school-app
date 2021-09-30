<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\DTOs\HomeworkData;
use App\DTOs\StudentHomeworkData;
use App\Repositories\HomeworkRepository;
use Illuminate\Support\Collection;

class HomeworkRepositoryTest extends TestCase
{
    public function test_createHomework_returns_Homework()
    {
        $expected = Homework::Factory()->make();
        $homeworkRepo = $this->createHomeworkRepository($expected);
        $homeworkData = HomeworkData::fromModel($expected);

        $result = $homeworkRepo->createHomework($homeworkData);
        $this->assertEquals($expected, $result);
    }

    public function test_assignHomework_returns_true()
    {
        $expected = StudentHomework::Factory()->make();
        $homeworkRepo = $this->createHomeworkRepository(null, $expected);
        $homeworkData = new HomeworkData();
        $homeworkData->id = 1;
        $homeworkData->assignees = [1];

        $result = $homeworkRepo->assignHomework($homeworkData);
        $this->assertTrue($result);
    }

    public function test_getHomework_returns_Homework()
    {
        $expected = Homework::Factory()->make();
        $homeworkId = 1;
        $homeworkRepo = $this->createHomeworkRepository($expected);

        $result = $homeworkRepo->getHomework($homeworkId);
        $this->assertEquals($expected, $result);
    }

    public function test_getStudentHomework_returns_StudentHomework()
    {
        $expected = StudentHomework::Factory()->make();
        $studentId = 1;
        $homeworkId = 1;
        $homeworkRepo = $this->createHomeworkRepository(null, $expected);

        $result = $homeworkRepo->getStudentHomework($studentId, $homeworkId);
        $this->assertEquals($expected, $result);
    }

    public function test_getHomeworks_returns_Homeworks()
    {
        $expected = new Collection();
        $studentId = 1;
        $homeworkRepo = $this->createHomeworkRepository();

        $result = $homeworkRepo->getHomeworks($studentId);
        $this->assertEquals($expected, $result);
    }

    public function test_submitHomework_returns_true()
    {
        $studentHomework = StudentHomework::Factory()->make();
        $homeworkRepo = $this->createHomeworkRepository(null, $studentHomework);
        $homeworkData = new StudentHomeworkData();
        $homeworkData->link = "";
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;

        $result = $homeworkRepo->submitHomework($homeworkData);
        $this->assertTrue($result);
    }

    private function createHomeworkRepository(
        Homework $homework = null,
        StudentHomework $studentHomework = null
    ) : HomeworkRepository
    {
        $mockHomework = $this->mockHomework($homework); 
        $mockStudentHomework = $this->mockStudentHomework($studentHomework); 
        return new HomeworkRepository($mockHomework, $mockStudentHomework);
    }

    private function mockHomework(Homework $homework = null) : Homework
    {
        return $this->mock(Homework::class, function ($mock) use ($homework) {
            $mock->shouldReceive('create')->andReturn($homework);
            $mock->shouldReceive('find')->andReturn($homework);
        });
    }

    private function mockStudentHomework(StudentHomework $studentHomework = null) : StudentHomework
    {
        return $this->mock(StudentHomework::class, function ($mock) use ($studentHomework) {
            $mock->shouldReceive('insert')->andReturn($studentHomework != null);
            $mock->shouldReceive('where->where->get')->andReturn(new Collection());
            $mock->shouldReceive('where->first')->andReturn($studentHomework);
            $mock->shouldReceive('where->where->update')->andReturn($studentHomework != null);
        });
    }
}
