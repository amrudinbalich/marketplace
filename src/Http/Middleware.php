<?php

namespace Amrudinbalic\Marketplace\Http;

class Middleware
{
    public function __construct(public array $middlewares) {}

    public function runAll(Request $request)
    {
        foreach($this->middlewares as $middleware) {
            $middleware = new $middleware();
            $middleware->handle($request);
        }
    }
}