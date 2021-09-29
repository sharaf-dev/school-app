<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetHomeworksTest extends TestCase
{
    private string $uri = 'api/homework/get';

    public function test_invalid_get_homeworks_response()
    {
        $expectedResponse = [
            'message' => true,
            'errors' => [
                'student_id' => true,
            ],
        ];

        $this->setServiceToken("student-svc");
        $response = $this->withHeaders($this->headers)
                        ->json('GET', $this->uri);

        $response->assertStatus(422);
        $response->assertJson($expectedResponse);
    }

    public function test_valid_get_homeworks_response()
    {
        $input = [ 'student_id' => 1 ];
        $expectedResponse = [
            'status' => 'HOMEWORKS_RETRIEVED',
            'message' => true,
            'data' => [
                'homeworks' => [],
            ],
        ];

        $this->setServiceToken("student-svc");
        $response = $this->withHeaders($this->headers)
                        ->json('GET', $this->uri, $input);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }
}
