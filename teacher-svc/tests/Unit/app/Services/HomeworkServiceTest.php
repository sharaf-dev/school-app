<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Models\Homework;
use App\Models\StudentHomework;
use App\Repositories\HomeworkRepository;
use App\Services\HomeworkService;
use App\DTOs\HomeworkData;
use App\DTOs\StudentHomeworkData;
use Illuminate\Support\Collection;
use App\Exceptions\ArgumentException;
use App\Exceptions\HomeworkNotFoundException;

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
        $homeworkSvc = $this->createHomeworkService();
        $homeworkData = new HomeworkData();
        $homeworkData->id = 1;
        $homeworkData->assignees = [1];
        
        $result = $homeworkSvc->assignHomework($homeworkData);
        $this->assertTrue($result);
    }

    public function test_assignHomework_throws_ArgumentException_for_empty_assignees()
    {
        $expected = StudentHomework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService(null, $expected);
        $homeworkData = new HomeworkData();

        $this->expectException(ArgumentException::class);
        $result = $homeworkSvc->assignHomework($homeworkData);
    }

    public function test_assignHomework_throws_ArgumentException_for_assignees_exist()
    {
        $expected = StudentHomework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService(null, $expected);
        $homeworkData = new HomeworkData();
        $homeworkData->id = 1;
        $homeworkData->assignees = [1];
        
        $this->expectException(ArgumentException::class);
        $result = $homeworkSvc->assignHomework($homeworkData);
    }

    public function test_getHomework_returns_homework()
    {
        $expected = Homework::Factory()->make(); 
        $homeworkId = 1;
        $homeworkSvc = $this->createHomeworkService($expected);

        $result = $homeworkSvc->getHomework($homeworkId);
        $this->assertEquals($expected, $result);
    }

    public function test_getHomeworks_returns_homeworks()
    {
        $expected = []; 
        $studentId = 1;
        $homeworkSvc = $this->createHomeworkService();

        $result = $homeworkSvc->getHomeworks($studentId);
        $this->assertEquals($expected, $result);
    }

    public function test_submitHomework_success()
    {
        $studentHomework = StudentHomework::Factory()->make();
        $homework = Homework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService($homework, $studentHomework);
        $homeworkData = new StudentHomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;

        $homeworkSvc->submitHomework($homeworkData);
    }

    public function test_submitHomework_throws_ArgumentException_if_already_submitted()
    {
        $studentHomework = StudentHomework::Factory()->make();
        $studentHomework->status = true;
        $homeworkSvc = $this->createHomeworkService(null, $studentHomework);
        $homeworkData = new StudentHomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;

        $this->expectException(ArgumentException::class);
        $homeworkSvc->submitHomework($homeworkData);
    }

    public function test_submitHomework_throws_HomeworkNotFound_if_homework_not_found()
    {
        $homeworkSvc = $this->createHomeworkService();
        $homeworkData = new StudentHomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;

        $this->expectException(HomeworkNotFoundException::class);
        $homeworkSvc->submitHomework($homeworkData);
    }

    public function test_submitHomework_throws_ArgumentException_on_failure()
    {
        $studentHomework = StudentHomework::Factory()->make();
        $homeworkSvc = $this->createHomeworkService(null, $studentHomework);
        $homeworkData = new StudentHomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;

        $this->expectException(ArgumentException::class);
        $homeworkSvc->submitHomework($homeworkData);
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
                $mock->shouldReceive('assignHomework')->andReturn(true);
                $mock->shouldReceive('getHomework')->andReturn($homework);
                $mock->shouldReceive('getHomeworks')->andReturn(new Collection());
                $mock->shouldReceive('getStudentHomework')->andReturn($studentHomework);
                $mock->shouldReceive('submitHomework')->andReturn($homework != null);
            }
        );
    }
}
