<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

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
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
