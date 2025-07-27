<?php

namespace App\Http\Middlewares;

use Amrudinbalic\Marketplace\Http\Request;

interface MiddlewareInterface
{
    public function handle(Request $request): bool;
}