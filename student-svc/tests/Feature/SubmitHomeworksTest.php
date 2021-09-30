<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SubmitHomeworksTest extends TestCase
{
    private string $uri = 'api/homework/submit';

    public function test_submit_homework_success()
    {
        Http::fake([
            'teacher-svc/api/homework/submit' => Http::response([], 200, [])
        ]);

        $input = [
            'homework_id' => 1,
            'link' => 'dummy_link',
        ];

        $expectedResponse = [
            'status' => 'HOMEWORK_SUBMITTED',
            'message' => true,
        ];

        $this->setUserToken();
        $response = $this->withHeaders($this->headers)
                         ->json('POST', $this->uri, $input);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }

    public function test_submit_homework_failure()
    {
        Http::fake([
            'teacher-svc/api/homework/submit' => Http::response([], 400, [])
        ]);

        $input = [
            'homework_id' => 1,
            'link' => 'dummy_link',
        ];

        $expectedResponse = [
            'status' => 'SUBMISSION_FAILED',
            'message' => true,
        ];

        $this->setUserToken();
        $response = $this->withHeaders($this->headers)
                         ->json('POST', $this->uri, $input);

        $response->assertStatus(400);
        $response->assertJson($expectedResponse);
    }
}
