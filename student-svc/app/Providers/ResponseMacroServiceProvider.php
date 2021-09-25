<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use App\Adapters\ApiResponseBuilder;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('custom', [ApiResponseBuilder::class, 'customResponse']);
        Response::macro('ok', [ApiResponseBuilder::class, 'okResponse']);
        Response::macro('badRequest', [ApiResponseBuilder::class, 'badRequestResponse']);
        Response::macro('unauthorized', [ApiResponseBuilder::class, 'unauthorizedResponse']);
        Response::macro('notFound', [ApiResponseBuilder::class, 'notFoundResponse']);
        Response::macro('error', [ApiResponseBuilder::class, 'errorResponse']);
    }
}
