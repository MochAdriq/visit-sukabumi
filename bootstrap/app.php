<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Alihkan halaman terlarang (403 Forbidden) ke halaman yang aman
        $exceptions->render(function (HttpExceptionInterface $e, Request $request) {
            if ($e->getStatusCode() === 403) {
                if ($request->expectsJson() || $request->is('livewire/*')) {
                    return null;
                }

                if (!auth()->check()) {
                    return redirect()->guest(route('login'))
                        ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman tersebut.');
                }

                return redirect()->route('home')
                    ->with('error', 'Akses ditolak: Anda tidak memiliki izin untuk membuka halaman tersebut.');
            }
        });
    })->create();
