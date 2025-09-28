<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: '/',
    )
    ->withExceptions(function (Exceptions $exceptions) {
        //если пользователь пытается перейти на несуществующую страницу
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('*') || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }
        });
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('*')) {
                return response()->json([
                    'message' => 'Not found.'
                ], 404);
            }
        });

        //если произошла ошибка валидация
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('*')) {
                $errors = $e->validator->errors()->toArray();
                $formattedErrors = array_fill_keys(array_keys($errors), "Validation error");
                return response()->json(array_merge([
                    'message' => "Validation error",
                ], $formattedErrors), 422);
            }
        });
    })
    ->withMiddleware(function (Middleware $middleware): void {

        //вместо перенаправления (как делает sanctum по умолчанию для неавторизованных пользователей
        //вернуть json-ответ
        $middleware->redirectGuestsTo("/profile");
        //если гость попытается перейти по ссылкам, где требуется авторизация - он получит
        //403, т.к. чтобы просмотреть свой профиль, нужно быть авторизованным, а sanctum для
        //обычной обработки неавторизованного пользователя предлагает только перенаправление, а не
        //обычное действие
    })
    ->create();
