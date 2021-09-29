<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetHomeworksTest extends TestCase
{
    private string $uri = 'api/homework/get';

    public function test_valid_get_homeworks_response()
    {
        $data = [
            'data' =>  [
                'homeworks' => [1, 2]
            ]
        ];
        Http::fake([
            'teacher-svc/api/homework/get?*' => Http::response($data, 200, [])
        ]);

        $expectedResponse = [
            'status' => 'HOMEWORKS_RETRIEVED',
            'message' => true,
            'data' => [
                'homeworks' => true,
            ],
        ];
        
        $this->setUserToken();
        $response = $this->withHeaders($this->headers)
                         ->get($this->uri);

        $response->assertStatus(200);
        $response->assertJson($expectedResponse);
    }
}
