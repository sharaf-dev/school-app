<?php

namespace Tests\Unit\app\Services;

use Tests\TestCase;
use App\Services\HomeworkService;
use App\Repositories\HomeworkRepository;
use App\DTOs\HomeworkData;

class HomeworkServiceTest extends TestCase
{
    public function test_getHomeworks_returns_homeworks()
    {
        $expected = [1, 2];
        $homeworkSvc = $this->createHomeworkService($expected);

        $result = $homeworkSvc->getHomeworks(1);
        $this->assertEquals($expected, $result);
    }

    public function test_getHomeworks_success()
    {
        $homework = [ 'status' => true ];
        $homeworkSvc = $this->createHomeworkService($homework);
        $homeworkData = new HomeworkData();

        $result = $homeworkSvc->submitHomework($homeworkData);
    }

    public function test_getHomeworks_throws_argument_exception()
    {
        $homework = [ 'status' => false ];
        $homeworkSvc = $this->createHomeworkService($homework);
        $homeworkData = new HomeworkData();

        $this->expectException(\InvalidArgumentException::class);
        $result = $homeworkSvc->submitHomework($homeworkData);
    }

    private function createHomeworkService(array $homeworks = []) : HomeworkService
    {
        $homeworkRepo = $this->mockHomeworkRepository($homeworks);
        return new HomeworkService($homeworkRepo);
    }

    private function mockHomeworkRepository(array $homeworks = []) : HomeworkRepository
    {
        return $this->mock(HomeworkRepository::class, function ($mock) use ($homeworks) {
            $mock->shouldReceive('getHomeworks')->andReturn($homeworks);
            $mock->shouldReceive('submitHomework')->andReturn($homeworks);
        });
    }
}
