<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('jsonSuccess', function ($data, $status = 200, $message = '') {
            return Response::make([
                'success' => true,
                'status' => $status,
                'data' => $data,
                'message' => ''
            ], $status);
        });

        Response::macro('jsonError', function ($errors, $status = 200, $message = '') {
            return Response::make([
                'success' => false,
                'status' => $status,
                'errors' => $errors,
                'message' => ''
            ], $status);
        });
    }
}
