<?php

namespace App\Adapters;

use Illuminate\Http\JsonResponse;

abstract class ResponseBuilder implements IResponseBuilder
{
    public static int $statusCode;
    public static string $status, $message;
    public static array $payload;
    public static array $headers;

    abstract protected static function buildResponse() : JsonResponse;

    abstract protected static function buildResponseBody() : array;

    /**
     * Returns formatted response with custom status code
     *
     * @param int $statusCode
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function customResponse(int $statusCode, string $status, string $message, array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = $statusCode;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns formatted ok success response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function okResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = 200;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns formatted bad request error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function badRequestResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = 400;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns formatted unauthorized error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function unauthorizedResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = 401;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns formatted not found error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function notFoundResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = 404;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns formatted Internal error response
     *
     * @param string $action
     * @param string $message
     * @param array $payload
     * @param array $headers
     *
     * @return JsonResponse
     */
    public static function errorResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse
    {
        self::$statusCode = 500;
        self::$status = $status;
        self::$message = $message;
        self::$payload = $payload;
        self::$headers = $headers;
        return static::buildResponse();
    }

    /**
     * Returns default message value correspond to the stats code
     *
     * @return string
     */
    protected static function buildResponseMessage() : string
    {
        if (self::$message) {
            return self::$message;
        }

        switch (self::$statusCode) {
            case 200: return 'Ok' ;
            case 400: return 'Bad Request';
            case 401: return 'Unauthorized';
            case 404: return 'Resource Not Found';
            case 500: return 'Internal Server Error';
        }
    }
}
