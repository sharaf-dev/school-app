<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetStudentsTest extends TestCase
{
    private string $uri = 'api/students/get';

    public function test_getStudents_returns_students()
    {
        $inputs = [
            'student_ids' => [1],
        ];

        $expectedResponse = [
            'status' => 'STUDENTS_RETRIEVED',
            'message' => true,
            'data' => [
                'students' => true,
            ],
        ];

        $this->setServiceToken("teacher-svc");
        $response = $this->withHeaders($this->headers)
                        ->json('GET', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }
}
