<?php

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
        // Daftarkan alias middleware khusus guru di sini
        $middleware->alias([
            'auth.guru' => \App\Http\Middleware\AuthGuru::class,
            'auth.siswa' => \App\Http\Middleware\AuthSiswa::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();