<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Homework;
use App\Models\StudentHomework;
use Illuminate\Support\Facades\Http;

class CreateHomeworkTest extends TestCase
{
    private string $uri = 'api/homework/create';

    public function test_valid_create_homework_response()
    {
        $homework = Homework::factory()->make();
        $inputs = [
            'title' => $homework->title,
            'description' => $homework->description,
        ];

        $expectedRecord = [
            'title' => $homework->title,
            'description' => $homework->description,
            'teacher_id' => $homework->teacher_id,
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_CREATED',
            'message' => true,
            'data' => [
                'homework_id' => true
            ]
        ];


        $this->setAuthorizationHeader();
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('homeworks', $expectedRecord);
    }

    public function test_valid_create_homework_with_assignees_response()
    {
        $data = [
            'data' =>  [
                'students' => [
                    ['id' => 2],
                ]
            ]
        ];

        Http::fake([
            'student-svc/api/students/get?*' => Http::response($data, 200, [])
        ]);

        $homework = Homework::factory()->make();
        $studentId = 2;
        $inputs = [
            'title' => $homework->title,
            'description' => $homework->description,
            'assignees' => [$studentId],
        ];

        $expectedHomeworkRecord = [
            'title' => $homework->title,
            'description' => $homework->description,
            'teacher_id' => $homework->teacher_id,
        ];

        $expectedStudentHomeworkRecord = [
            'homework_id' => 1,
            'student_id' => $studentId,
            'status' => StudentHomework::STATUS_NEW,
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_CREATED_ASSIGNED',
            'message' => true,
            'data' => [
                'homework_id' => true,
                'students' => [$studentId],
            ]
        ];

        $this->setAuthorizationHeader();
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('homeworks', $expectedHomeworkRecord);
        $this->assertDatabaseHas('student_homework', $expectedStudentHomeworkRecord);
    }
}
