<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
                  ->withRouting(
                      web: __DIR__ . '/../routes/web.php',
                      commands: __DIR__ . '/../routes/console.php',
                      health: '/up',
                  )
                  ->withMiddleware(function (Middleware $middleware) {
                      $middleware->appendToGroup('tenant', [
                          \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class,
                          \Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession::class,
                      ]);

                      $middleware->alias([
                          'role'     => \Spatie\Permission\Middleware\RoleMiddleware::class,
                          'landlord' => \App\Http\Middleware\LandlordOnly::class
                      ]);
                  })
                  ->withCommands([
                      \Mth\Landlord\Adapters\Commands\CreateTenant::class
                  ])
                  ->withExceptions(function (Exceptions $exceptions) {
                      //
                  })->create();

