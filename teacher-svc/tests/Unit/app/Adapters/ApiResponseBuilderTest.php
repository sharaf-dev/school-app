<?php

namespace Tests\Unit\app\Adapters;

use Tests\TestCase;
use App\Adapters\ApiResponseBuilder;

class ApiResponseBuilderTest extends TestCase
{
    private string $action = 'TEST STATUS';
    private string $message = 'test message';
    private array $data = ['dummy_key' => 'dummy message'];
    protected array $headers = ['dummy_header' => 'dummy value'];

    public function expectedResponse() : string
    {
        return json_encode([
            'status' => $this->action,
            'message' => $this->message,
            'data' => $this->data
        ]);
    }

    public function expectedErrorResponse() : string
    {
        return json_encode([
            'status' => $this->action,
            'message' => $this->message,
            'errors' => $this->data
        ]);
    }

    public function testOkResponse() : void
    {
        $response = ApiResponseBuilder::okResponse(
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(200, $response->status());
        $this->assertEquals($this->expectedResponse(), $response->content());
    }

    public function testDefaultOkResponse() : void
    {
        $response = ApiResponseBuilder::okResponse($this->action);
        $responseBody = json_decode($response->content());

        $this->assertEquals(200, $response->status());
        $this->assertEquals('Ok', $responseBody->message);
    }

    public function testbadRequestResponse() : void
    {
        $response = ApiResponseBuilder::badRequestResponse(
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(400, $response->status());
        $this->assertEquals($this->expectedErrorResponse(), $response->content());
    }

    public function testDefaultBadRequestResponse() : void
    {
        $response = ApiResponseBuilder::badRequestResponse($this->action);
        $responseBody = json_decode($response->content());

        $this->assertEquals(400, $response->status());
        $this->assertEquals('Bad Request', $responseBody->message);
    }

    public function testunauthorizedResponse() : void
    {
        $response = ApiResponseBuilder::unauthorizedResponse(
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(401, $response->status());
        $this->assertEquals($this->expectedErrorResponse(), $response->content());
    }

    public function testDefaultUnauthorizedResponse() : void
    {
        $response = ApiResponseBuilder::unauthorizedResponse($this->action);
        $responseBody = json_decode($response->content());

        $this->assertEquals(401, $response->status());
        $this->assertEquals('Unauthorized', $responseBody->message);
    }

    public function testnotFoundResponse() : void
    {
        $response = ApiResponseBuilder::notFoundResponse(
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(404, $response->status());
        $this->assertEquals($this->expectedErrorResponse(), $response->content());
    }

    public function testDefaultNotFoundResponse() : void
    {
        $response = ApiResponseBuilder::notFoundResponse($this->action);
        $responseBody = json_decode($response->content());

        $this->assertEquals(404, $response->status());
        $this->assertEquals('Resource Not Found', $responseBody->message);
    }


    public function testerrorResponse() : void
    {
        $response = ApiResponseBuilder::errorResponse(
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(500, $response->status());
        $this->assertEquals($this->expectedErrorResponse(), $response->content());
    }

    public function testDefaultErrorResponse() : void
    {
        $response = ApiResponseBuilder::errorResponse($this->action);
        $responseBody = json_decode($response->content());

        $this->assertEquals(500, $response->status());
        $this->assertEquals('Internal Server Error', $responseBody->message);
    }

    public function testCustomSuccessResponse() : void
    {
        $response = ApiResponseBuilder::customResponse(
            202,
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(202, $response->status());
        $this->assertEquals($this->expectedResponse(), $response->content());
    }

    public function testCustomErrorResponse() : void
    {
        $response = ApiResponseBuilder::customResponse(
            503,
            $this->action,
            $this->message,
            $this->data,
            $this->headers
        );

        $this->assertEquals(503, $response->status());
        $this->assertEquals($this->expectedErrorResponse(), $response->content());
    }
}
