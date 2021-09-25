<?php

namespace App\Adapters;

use Illuminate\Http\JsonResponse;

interface IResponseBuilder
{
    public static function customResponse(int $statusCode, string $status, string $message, array $payload = [], array $headers = []) : JsonResponse;

    public static function okResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse;

    public static function badRequestResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse;

    public static function unauthorizedResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse;

    public static function notFoundResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse;

    public static function errorResponse(string $status, string $message = '', array $payload = [], array $headers = []) : JsonResponse;
}
