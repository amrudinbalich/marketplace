<?php

/**
 * Middlewares
 * List in all the middlewares that needs needs to be passed in the app.
 */

use Amrudinbalic\Marketplace\Http\Middleware;
use Amrudinbalic\Marketplace\Http\Request;

$middlewareRunner = new Middleware([
    \App\Http\Middlewares\TrimWhitespacesMiddleware::class,
    \App\Http\Middlewares\AuthMiddleware::class,
]);
$middlewareRunner->runAll($container->get(Request::class));
