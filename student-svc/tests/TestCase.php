<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Helpers\TokenHelper;
use App\Models\Student;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headers = [];

    public function SetUp() : void
    {
        Parent::Setup();
        $this->artisan('migrate:fresh --seed');
    }

    public function setServiceToken($issuer)
    {
        $helper = new TokenHelper(360, $issuer);
        $token = $helper->generateServiceToken();
        $this->headers['Authorization'] = "Bearer {$token}";
    }

    public function setUserToken() : void
    {
        $uri = 'api/login';
        $student = Student::factory()->make();
        $inputs = [
            'email' => $student->email,
            'password' => 'password',
        ];

        $response = $this->json('POST', $uri, $inputs);
        $token = $this->getToken($response);
        $this->headers = [
            'Authorization' => "Bearer {$token}"
        ];
    }

    public function getToken(object $response) : string
    {
        $content = $response->decodeResponseJson();
        return $content['data']['token'];
    }
}
