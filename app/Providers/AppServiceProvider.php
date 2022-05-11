<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Faculty\FacultyRepositoryInterface::class,
            \App\Repositories\Faculty\FacultyRepository::class
        );
        $this->app->bind(
            \App\Repositories\Student\StudentRepositoryInterface::class,
            \App\Repositories\Student\StudentRepository::class
        );
        $this->app->bind(
            \App\Repositories\Subject\SubjectRepositoryInterface::class,
            \App\Repositories\Subject\SubjectRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
