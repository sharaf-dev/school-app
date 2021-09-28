<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Carbon\Carbon;
use App\Exceptions\InvalidTokenException;

class TokenHelper
{
    private string $jwtSecret = "";
    private string $issuer = "";
    private int $tokenValidity = 0;
    private array $algorithm = ['HS256'];
    private array $services = [
        'student-svc'
    ];

    public function __construct(int $tokenValidity = 360, string $issuer = "teacher-svc")
    {
        $this->tokenValidity = $tokenValidity;
        $this->issuer = $issuer;
        $this->jwtSecret = env('JWT_SECRET');
    }

    public function generateServiceToken() : string
    {
        $payload = [
            'iss' => $this->issuer,
            'exp' => now()->addSeconds($this->tokenValidity)
        ];
        return JWT::encode($payload, $this->jwtSecret);
    }

    public function validateServiceToken(string $token) : void
    {
        $payload = JWT::decode($token, $this->jwtSecret, $this->algorithm);
        $expiry = Carbon::parse($payload->exp);
        if (now()->gt($expiry))
        {
            throw new InvalidTokenException('Token expired');
        }

        if (!in_array($payload->iss, $this->services))
        {
            throw new InvalidTokenException('Invalid token issuer');
        }
    }
}
