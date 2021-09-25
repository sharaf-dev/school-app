<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ITeacherService;
use App\Services\TeacherService;
use App\Repositories\ITeacherRepository;
use App\Repositories\TeacherRepository;

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
        $this->app->bind(ITeacherRepository::class, TeacherRepository::class);
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
