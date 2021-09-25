<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\IStudentService;
use App\Services\StudentService;
use App\Repositories\IStudentRepository;
use App\Repositories\StudentRepository;

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
        $this->app->bind(IStudentRepository::class, StudentRepository::class);
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
