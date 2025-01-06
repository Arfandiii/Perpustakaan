<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Illuminate\Support\Facades\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => MiddlewareAuthenticate::class,
            'role' => RoleMiddleware::class
        ]); // Tambahkan di sini
    })
    ->withSchedule(function($schedule) {
        $schedule->command('update:book-status')->everyFiveMinutes();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
