<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\Helpers\TokenHelper;
use App\Exceptions\InvalidTokenException;

class VerifyServiceToken
{
    public function __construct(public TokenHelper $helper) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            $this->helper->validateServiceToken($token);
            return $next($request);
        } catch (InvalidTokenException $e) {
            return response()->unauthorized('INVALID_TOKEN', $e->getMessage());
        }
    }
}
