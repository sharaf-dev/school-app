<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Adapters\HttpClient;
use App\Repositories\HomeworkRepository;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use App\DTOs\HomeworkData;

class HomeworkRepositoryTest extends TestCase
{
    public function test_getHomeworks_returns_homeworks()
    {
        $data = [
            'data' =>  [
                'homeworks' => [1, 2]
            ]
        ];
        $expected = Arr::get($data, 'data.homeworks');
        $response = $this->mock(Response::class, function ($mock) use ($data) {
            $mock->shouldReceive('successful')->andReturn(true);
            $mock->shouldReceive('json')->andReturn($data);
        });
        $homeworkRepo = $this->createHomeworkRepository($response);

        $result = $homeworkRepo->getHomeworks(1);
        $this->assertEquals($expected, $result);
    }

    public function test_getHomeworks_returns_empty_array_on_failure()
    {
        $expected = [];
        $response = $this->mock(Response::class, function ($mock) {
            $mock->shouldReceive('successful')->andReturn(false);
        });
        $homeworkRepo = $this->createHomeworkRepository($response);

        $result = $homeworkRepo->getHomeworks(1);
        $this->assertEquals($expected, $result);
    }

    public function test_submitHomework_returns_success_array()
    {
        $expected = [
            'status' => true,
            'data' => "dummy data",
        ];
        $response = $this->mock(Response::class, function ($mock) use ($expected) {
            $mock->shouldReceive('successful')->andReturn(true);
            $mock->shouldReceive('json')->andReturn($expected['data']);
        });
        $homeworkRepo = $this->createHomeworkRepository($response);
        $homeworkData = new HomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;
        $homeworkData->link = "";

        $result = $homeworkRepo->submitHomework($homeworkData);
        $this->assertEquals($expected, $result);
    }

    public function test_submitHomework_returns_failure_array()
    {
        $expected = [
            'status' => false,
            'data' => []
        ];
        $response = $this->mock(Response::class, function ($mock) {
            $mock->shouldReceive('successful')->andReturn(false);
            $mock->shouldReceive('json')->andReturn([]);
        });
        $homeworkRepo = $this->createHomeworkRepository($response);
        $homeworkData = new HomeworkData();
        $homeworkData->studentId = 1;
        $homeworkData->homeworkId = 1;
        $homeworkData->link = "";

        $result = $homeworkRepo->submitHomework($homeworkData);
        $this->assertEquals($expected, $result);
    }

    private function createHomeworkRepository($response = null) : HomeworkRepository
    {
        $mockHttpClient = $this->mockHttpClient($response);
        return new HomeworkRepository($mockHttpClient);
    }

    private function mockHttpClient($response = []) : HttpClient
    {
        return $this->mock(HttpClient::class, function ($mock) use ($response) {
            $mock->shouldReceive('get')->andReturn($response);
            $mock->shouldReceive('post')->andReturn($response);
        });
    }
}
