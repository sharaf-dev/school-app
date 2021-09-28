<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\Homework;

class AssignHomeworkTest extends TestCase
{
    private string $uri = 'api/homework/assign';

    public function test_valid_assign_homework_response()
    {
        $data = [
            'data' =>  [
                'students' => [
                    ['id' => 1],
                ]
            ]
        ];

        Http::fake([
            'student-svc/api/students/get?*' => Http::response($data, 200, [])
        ]);

        $inputs = [
            'homework_id' => 1,
            'assignees' => [1],
        ];

        $expectedRecord = [
            'homework_id' => 1,
            'student_id' => 1,
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_ASSIGNED',
            'message' => true,
            'data' => [
                'homework_id' => true,
                'students' => true
            ]
        ];

        Homework::factory()->make()->save();
        $this->setAuthorizationHeader();
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('student_homework', $expectedRecord);
    }

    public function test_assign_homework_return_homework_not_found()
    {
        $data = [
            'data' =>  [
                'students' => [
                    ['id' => 1],
                ]
            ]
        ];

        Http::fake([
            'student-svc/api/students/get?*' => Http::response($data, 200, [])
        ]);

        $inputs = [
            'homework_id' => 1,
            'assignees' => [1],
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_NOT_FOUND',
            'message' => true,
        ];

        $this->setAuthorizationHeader();
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(404);
        $response->assertJson($expectedResponse);
    }

    public function test_assign_homework_return_student_not_found()
    {
        $data = [
            'data' =>  [
                'students' => [
                    ['id' => 1],
                ]
            ]
        ];

        Http::fake([
            'student-svc/api/students/get?*' => Http::response($data, 200, [])
        ]);

        $inputs = [
            'homework_id' => 1,
            'assignees' => [5],
        ];

        $expectedResponse = [
            'status' => 'STUDENTS_NOT_FOUND',
            'message' => true,
        ];

        Homework::factory()->make()->save();
        $this->setAuthorizationHeader();
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(404);
        $response->assertJson($expectedResponse);
    }
}
