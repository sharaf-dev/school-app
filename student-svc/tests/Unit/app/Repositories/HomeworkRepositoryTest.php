<?php

namespace Tests\Unit\app\Repositories;

use Tests\TestCase;
use App\Adapters\HttpClient;
use App\Repositories\HomeworkRepository;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

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

    private function createHomeworkRepository($response = null) : HomeworkRepository
    {
        $mockHttpClient = $this->mockHttpClient($response);
        return new HomeworkRepository($mockHttpClient);
    }

    private function mockHttpClient($response = []) : HttpClient
    {
        return $this->mock(HttpClient::class, function ($mock) use ($response) {
            $mock->shouldReceive('get')->andReturn($response);
        });
    }
}
