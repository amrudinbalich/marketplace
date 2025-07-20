<?php

namespace Amrudinbalic\Marketplace\Http;

class Session
{
    public static function destroy(): void {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function unsetFlashMessages(): void {
        if (isset($_SESSION['flash'])) {
            unset($_SESSION['flash']);
        }
    }
}