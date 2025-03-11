<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception) {
            $className = get_class($exception);
            $index = strrpos($className, '\\');

            if ($className === 'Illuminate\Validation\ValidationException') {
                foreach ($exception->errors() as $key => $value) {
                    foreach ($value as $message) {
                        $errors[] = [
                            'status' => 422,
                            'message' => $message,
                            'source' => $key
                        ];
                    }
                }

                return response()->json([$errors]);
            }

            if ($className === 'Illuminate\Database\Eloquent\ModelNotFoundException') {
                return response()->json([
                    [
                        'status' => 404,
                        'message' => 'The resource cannot be found.',
                        'source' => $exception->getModel()
                    ]
                ]);
            }

            if ($className === 'Illuminate\Auth\AuthenticationException') {
                return response()->json([
                    [
                        'status' => 401,
                        'message' => 'Unauthenticated',
                        'source' => ''
                    ]
                ]);
            }

            return response()->json([
                [
                    'type' => substr($className, $index + 1),
                    'status' => 0,
                    'message' => $exception->getMessage(),
                    'source' => 'Line: ' . $exception->getLine() . ': ' . $exception->getFile()
                ]
            ]);
        });
    })->create();
