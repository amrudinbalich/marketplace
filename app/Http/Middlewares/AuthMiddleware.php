<?php

namespace App\Http\Middlewares;

use App\Http\Middlewares\MiddlewareInterface;
use Amrudinbalic\Marketplace\Http\Request;
use Amrudinbalic\Marketplace\Http\Session;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): bool
    {
        $authenticated = Session::authenticated();

        $path = $request->path();
        $excludedPaths = config('session-auth.excluded_paths');

        // route is not controlled by auth
        if(in_array($path, $excludedPaths)) {
            return true;
        }

        // route is controlled by auth, but user is not authenticated
        if(!$authenticated && !in_array($path, $excludedPaths)) {
            redirect('user/login');
        }

        return true;
    }
}