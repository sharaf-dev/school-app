<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\IStudentService;
use App\Services\StudentService;
use App\Services\IHomeworkService;
use App\Services\HomeworkService;
use App\Repositories\IStudentRepository;
use App\Repositories\StudentRepository;
use App\Repositories\IHomeworkRepository;
use App\Repositories\HomeworkRepository;
use App\Adapters\IHttpClient;
use App\Adapters\HttpClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IStudentService::class, StudentService::class);
        $this->app->bind(IHomeworkService::class, HomeworkService::class);
        $this->app->bind(IStudentRepository::class, StudentRepository::class);
        $this->app->bind(IHomeworkRepository::class, HomeworkRepository::class);
        $this->app->singleton(IHttpClient::class, HttpClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
