<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\DTOs\HomeworkData;
use App\Repositories\HomeworkRepository;

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
        });
    }

    private function mockStudentHomework(StudentHomework $studentHomework = null) : StudentHomework
    {
        return $this->mock(StudentHomework::class, function ($mock) use ($studentHomework) {
            $mock->shouldReceive('insert')->andReturn($studentHomework != null);
        });
    }
}
