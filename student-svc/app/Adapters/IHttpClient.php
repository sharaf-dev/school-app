<?php

namespace App\Adapters;

use Illuminate\Http\Client\Response; 

interface IHttpClient
{
    public function post(string $url, array $data = [], array $headers = []) : Response;

    public function get(string $url, array $data = [], array $headers = []) : Response;
}
