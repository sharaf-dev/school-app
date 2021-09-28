<?php

namespace Tests\Unit\app\Repositories;

use Illuminate\Http\Client\Response;
use Tests\TestCase;
use App\Repositories\StudentRepository;
use App\Adapters\HttpClient;
use Illuminate\Support\Arr;

class StudentRepositoryTest extends TestCase
{
    public function test_GetStudents_returns_array()
    {
        $data = [
            'data' =>  [
                'students' => []
            ]
        ];
        $expected = Arr::get($data, 'data.students');

        $response = $this->mock(Response::class, function ($mock) use ($data) {
            $mock->shouldReceive('successful')->andReturn(true);
            $mock->shouldReceive('json')->andReturn($data);
        });
        $studentRepo = $this->createStudentRepository($response);

        $result = $studentRepo->getStudents([1, 2]);
        $this->assertEquals($expected, $result);
    }

    public function test_GetStudents_returns_empty_array_on_failure()
    {
        $expected = [];
        $response = $this->mock(Response::class, function ($mock) {
            $mock->shouldReceive('successful')->andReturn(false);
        });
        $studentRepo = $this->createStudentRepository($response);

        $result = $studentRepo->getStudents([1, 2]);
        $this->assertEquals($expected, $result);
    }

    private function createStudentRepository($response = null) : StudentRepository
    {
        $mockHttpClient = $this->mockHttpClient($response); 
        return new StudentRepository($mockHttpClient);
    }

    private function mockHttpClient($response = []) : HttpClient
    {
        return $this->mock(HttpClient::class, function ($mock) use ($response) {
            $mock->shouldReceive('get')->andReturn($response);
        });
    }
}
