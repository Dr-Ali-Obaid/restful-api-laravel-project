<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // 401 errors - Authentication
        $exceptions->renderable(function (RouteNotFoundException $e) {
            return response()->json([
                'error' => 'Unauthenticated: Please log in first'
            ], 401);
        });
        // 405 errors
        $exceptions->renderable(function (MethodNotAllowedHttpException $e) {
            return response()->json([
                'error' => 'Not True Request Type'
            ], 405);
        });
        // 404 errors
        $exceptions->renderable(function (NotFoundHttpException $e) {
            return response()->json([
                'error' => 'User Or Record Not Found'
            ], 404);
        });
        // 403 Authorization errors
        $exceptions->renderable(function (AuthorizationException $e) {
            return response()->json([
                'error' => $e->getMessage() // تظهر رسالة Policy هنا
            ], 403);
        });

        // general errors
        // $exceptions->renderable(function (Throwable $e) {
        //     return response()->json([
        //         'error' => 'some thing went wrong'
        //     ], 500);
        // });
    })->create();
