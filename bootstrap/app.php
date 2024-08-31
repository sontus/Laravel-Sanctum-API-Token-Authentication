<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (){
            Route::namespace('Auth')
                ->prefix('api')
                ->name('auth.')
                ->group(__DIR__.'/../routes/auth.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
       $middleware->redirectGuestsTo('api/unauthorized');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
