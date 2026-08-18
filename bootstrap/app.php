<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectUsersTo(function (Request $request) {
            if (Auth::guard('student')->check()) {
                return route('student.dashboard');
            }

            if (Auth::guard('web')->check()) {
                $user = Auth::guard('web')->user();

                return match ($user->role) {
                    'admin'   => route('dashboard'),
                    'cashier' => route('home'),
                    default   => route('dashboard'),
                };
            }

            return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
