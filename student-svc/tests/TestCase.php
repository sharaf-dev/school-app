<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
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

    public function setServiceToken($issuer)
    {
        $helper = new TokenHelper(360, $issuer);
        $token = $helper->generateServiceToken();
        $this->headers['Authorization'] = "Bearer {$token}";
    }
}
