<?php

namespace App\Http\Middlewares;

use App\Http\Middlewares\MiddlewareInterface;
use Amrudinbalic\Marketplace\Http\Request;

class TrimWhitespacesMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): bool
    {
        $all = $request->all();

        foreach($all as $key => $value) {
            $all[$key] = trim($value);
        }

        return true;
    }
}