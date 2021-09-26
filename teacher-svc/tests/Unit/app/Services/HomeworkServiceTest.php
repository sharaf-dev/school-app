<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\Repositories\HomeworkRepository;
use App\Services\HomeworkService;
use App\DTOs\HomeworkData;

class HomeworkServiceTest extends TestCase
{
    public function test_createHomework_returns_Homework()
    {
        $expected = Homework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService($expected);
        $homeworkData = new HomeworkData();
        
        $result = $homeworkSvc->createHomework($homeworkData);
        $this->assertEquals($expected, $result);
    }

    public function test_assignHomework_returns_true()
    {
        $expected = StudentHomework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService(null, $expected);
        $homeworkData = new HomeworkData();
        $homeworkData->assignees = [1];
        
        $result = $homeworkSvc->assignHomework($homeworkData);
        $this->assertTrue($result);
    }

    public function test_assignHomework_throws_InvalidArgumentException()
    {
        $expected = StudentHomework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService(null, $expected);
        $homeworkData = new HomeworkData();
        
        $this->expectException(\InvalidArgumentException::class);
        $result = $homeworkSvc->assignHomework($homeworkData);
    }

    private function createHomeworkService(
        Homework $homework = null,
        StudentHomework $studentHomework = null
    ) : HomeworkService
    {
        $homeworkRepo = $this->mockHomeworkRepository($homework, $studentHomework);
        return new HomeworkService($homeworkRepo);
    }

    private function mockHomeworkRepository(
        Homework $homework = null,
        StudentHomework $studentHomework = null
    ) : HomeworkRepository
    {
        return $this->mock(
            HomeworkRepository::class,
            function ($mock) use ($homework, $studentHomework) {
                $mock->shouldReceive('createHomework')->andReturn($homework);
                $mock->shouldReceive('assignHomework')->andReturn($studentHomework != null);
            }
        );
    }
}
