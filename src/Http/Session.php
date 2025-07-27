<?php

namespace Amrudinbalic\Marketplace\Http;

class Session
{
    public static function startIfNotActive(): void {
        if(!session_id()) {
            session_start();
        }
    }

    public static function destroy(): void {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function unsetFlashMessages(): void {
        if (isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }
    }

    public static function authenticated(): bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
}