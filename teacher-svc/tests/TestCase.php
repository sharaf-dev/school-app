<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Teacher;
use App\Helpers\TokenHelper;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headers = [];

    public function SetUp() : void
    {
        Parent::Setup();
        $this->artisan('migrate:fresh --seed');
    }

    public function setAuthorizationHeader() : void
    {
        $uri = 'api/login';
        $teacher = Teacher::factory()->make();
        $inputs = [
            'email' => $teacher->email,
            'password' => 'password',
        ];

        $response = $this->json('POST', $uri, $inputs);
        $token = $this->getToken($response);
        $this->headers = [
            'Authorization' => "Bearer {$token}"
        ];
    }

    public function setServiceToken($issuer)
    {
        $helper = new TokenHelper(360, $issuer);
        $token = $helper->generateServiceToken();
        $this->headers['Authorization'] = "Bearer {$token}";
    }

    public function getToken(object $response) : string
    {
        $content = $response->decodeResponseJson();
        return $content['data']['token'];
    }
}

