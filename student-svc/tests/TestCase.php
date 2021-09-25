<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected array $headers = [];

    public function SetUp() : void
    {
        Parent::Setup();
        $this->artisan('migrate:fresh --seed');
    }
}
