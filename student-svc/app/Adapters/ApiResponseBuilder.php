<?php

namespace App\Adapters;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;

class ApiResponseBuilder extends ResponseBuilder
{
    /**
     * Returns formatted api response
     *
     * @return JsonResponse
     */
    protected static function buildResponse() : JsonResponse
    {
        return Response::json(
            self::buildResponseBody(), 
            self::$statusCode
        );
    }

    /**
     * Returns formatted response body
     *
     * @return array
     */
    protected static function buildResponseBody() : array
    {
        $body = [
            'status' => self::$status,
            'message' => self::buildResponseMessage(),
        ];

        if (self::$payload) {
            if (self::$statusCode < 300 && self::$statusCode >= 200) {
                $body['data'] = self::$payload;
            } else {
                $body['errors'] = self::$payload;
            }
        }

        return $body;
    }
}
