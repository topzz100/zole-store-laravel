<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        // 1. Explicitly configure the 'api' middleware group.
        // This group should NOT contain session or CSRF middleware.
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            // You may need to add the default Sanctum/API middleware here
        ]);

        // 2. Explicitly configure the 'web' middleware group.
        // This ensures the VerifyCsrfToken middleware is ONLY applied to web routes.
        $middleware->web(append: [
            // CRUCIAL: Add the CSRF Middleware back, but ONLY to the web group.
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,

            // Other web-specific middleware
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
