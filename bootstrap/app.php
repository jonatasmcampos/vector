<?php

use App\Exceptions\ExceptionFactory;
use App\Exceptions\Handlers\ExceptionLogger;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $exception) {            
            $logger = new ExceptionLogger();
            $logger->log($exception);
        });

        $exceptions->render(function (Throwable $exception, $request) {
            $exception_factory = new ExceptionFactory();
            $exception_strategy = $exception_factory->make($exception);
            return $exception_strategy->handle($exception);
        });
    })->create();
