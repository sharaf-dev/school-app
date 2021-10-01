<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ITeacherService;
use App\Services\IStudentService;
use App\Services\IHomeworkService;
use App\Services\TeacherService;
use App\Services\HomeworkService;
use App\Services\StudentService;
use App\Repositories\ITeacherRepository;
use App\Repositories\IStudentRepository;
use App\Repositories\IHomeworkRepository;
use App\Repositories\HomeworkRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\StudentRepository;
use App\Adapters\HttpClient;
use App\Adapters\IHttpClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ITeacherService::class, TeacherService::class);
        $this->app->bind(IHomeworkService::class, HomeworkService::class);
        $this->app->bind(IStudentService::class, StudentService::class);
        $this->app->bind(IHomeworkRepository::class, HomeworkRepository::class);
        $this->app->bind(ITeacherRepository::class, TeacherRepository::class);
        $this->app->bind(IStudentRepository::class, StudentRepository::class);
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
