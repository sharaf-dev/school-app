<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\StudentHomework;
use App\Models\Homework;

class SubmitHomeworksTest extends TestCase
{
    private string $uri = 'api/homework/submit';

    public function test_submit_homework_success_response()
    {
        Homework::factory()->make()->save();
        StudentHomework::factory()->make()->save();
        $inputs = [
            'student_id' => 1,
            'homework_id' => 1,
            'link' => 'dummy_link',
        ];

        $expectedRecord = [
            'homework_id' => 1,
            'student_id' => 1,
            'status' => StudentHomework::STATUS_SUBMITTED,
            'link' => $inputs['link'],
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_SUBMITTED',
            'message' => true,
        ];

        $this->setServiceToken('student-svc');
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('student_homework', $expectedRecord);
    }

    public function test_submit_homework_return_failed_respnose_when_already_submitted()
    {
        Homework::factory()->make()->save();
        $studentHomework = StudentHomework::factory()->make();
        $studentHomework->status = StudentHomework::STATUS_SUBMITTED;
        $studentHomework->save();

        $inputs = [
            'student_id' => 1,
            'homework_id' => 1,
            'link' => 'dummy_link',
        ];

        $expectedResponse = [
            'status' => 'SUBMISSION_FAILED',
            'message' => true,
        ];

        $this->setServiceToken('student-svc');
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(400);
        $response->assertJson($expectedResponse);
    }

    public function test_submit_homework_return_failed_respnose_when_homework_not_found()
    {
        Homework::factory()->make()->save();
        StudentHomework::factory()->make()->save();
        $inputs = [
            'student_id' => 1,
            'homework_id' => 2,
            'link' => 'dummy_link',
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_NOT_FOUND',
            'message' => true,
        ];

        $this->setServiceToken('student-svc');
        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(404);
        $response->assertJson($expectedResponse);
    }
}
