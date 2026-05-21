<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
        $exceptions->render(function (ValidationException $e) {
            return new JsonResponse([
                'message' => 'The given data was invalid.',
                'errors'  => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (\App\Exceptions\VoucherAlreadyExistsException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 409);
        });

        $exceptions->render(function (\App\Exceptions\UnsupportedAircraftException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 422);
        });
    })->create();
