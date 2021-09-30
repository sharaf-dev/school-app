<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use App\Helpers\TokenHelper;

class HttpClient implements IHttpClient
{
    public function __construct(public TokenHelper $helper) {}

    public function post(string $url, array $data = [], array $headers = []) : Response
    {
        try
        {
            $headers = $this->populateHeaders($headers);
            return Http::retry(3, 100)->withHeaders($headers)->post($url, $data);
        }
        catch (RequestException $e)
        {
            return $e->response;
        }
    }

    public function get(string $url, array $data = [], array $headers = []) : Response
    {
        try
        {
            $headers = $this->populateHeaders($headers);
            return Http::retry(3, 100)->withHeaders($headers)->get($url, $data);
        }
        catch (RequestException $e)
        {
            return $e->response;
        }
    }

    private function populateHeaders(array $headers) : array
    {
        if (!in_array('authorization', $headers))
        {
            $headers['authorization'] = "Bearer {$this->helper->generateServiceToken()}";
        }

        return $headers;
    }
}
