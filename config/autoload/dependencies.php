<?php

declare(strict_types=1);
/**
 * Multi-user mall
 *
 * @link     https://store.yii.red
 * @document https://document.store.yii.red
 * @contact  8257796@qq.com
 */
return [
    Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler::class => App\Exception\Handler\HttpExceptionHandler::class,
    Hyperf\Validation\ValidationExceptionHandler::class => App\Exception\Handler\ValidationExceptionHandler::class,
    Hyperf\HttpServer\CoreMiddleware::class => App\Middleware\CoreMiddleware::class,
];
