<?php

use App\Http\Middleware\AuthorizeCanAnyMiddleware;
use App\Http\Middleware\BriefingMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',)
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'canAny' => AuthorizeCanAnyMiddleware::class,
            'briefing' => BriefingMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
