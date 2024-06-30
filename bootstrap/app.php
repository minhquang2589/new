<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CustomCheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    // ->withRouting(
    //     commands: __DIR__ . '/../routes/console.php',
    //     using: function () {
    //         Route::prefix('api')->group(function () {
    //             Route::group([], function () {
    //                 require base_path('routes/admin.php');
    //                 require base_path('routes/user.php');
    //             });
    //         });

    //         Route::view('/{any}', 'app')->where('any', '.*');
    //     },
    // )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => CustomCheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
