<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Student;

class StudentLoginTest extends TestCase
{
    private string $uri = 'api/login';

    public function test_empty_input_login_response()
    {
        $expectedResponse = [
            'message' => true,
            'errors' => [
                'email' => true,
                'password' => true
            ],
        ];

        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri);

        $response->assertStatus(422);
        $response->assertJson($expectedResponse);
    }

    public function test_valid_login_response()
    {
        $student = Student::factory()->make();
        $inputs = [
            'email' => $student->email,
            'password' => 'password',
        ];

        $expectedRecord = [
            'tokenable_id' => 1,
            'name' => $student->student_id,
        ];

        $expectedResponse = [
            'status' => 'LOGIN_SUCCESS',
            'message' => true,
            'data' => [
                'token' => true
            ]
        ];

        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
        $this->assertDatabaseHas('personal_access_tokens', $expectedRecord);
    }

    public function test_invalid_login_response()
    {
        $inputs = [
            'email' => 'dummy@test.com',
            'password' => '123',
        ];

        $expectedResponse = [
            'status' => 'LOGIN_FAILED',
            'message' => true
        ];

        $response = $this->withHeaders($this->headers)
                        ->json('POST', $this->uri, $inputs);

        $response->assertStatus(401);
        $response->assertJson($expectedResponse);
    }
}
