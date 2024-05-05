<?php

namespace App\Providers;

use App\Repositories\CarDefaultRepository;
use App\Repositories\CarRepositoryInterface;
use App\Repositories\UserDefaultRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\CarService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserDefaultRepository::class);
        $this->app->bind(UserService::class, function ($app) {
            return new UserService($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(CarRepositoryInterface::class, CarDefaultRepository::class);
        $this->app->bind(CarService::class, function ($app) {
            return new CarService($app->make(CarRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
