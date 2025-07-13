<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [

    // Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        return new Environment($loader, [
            'cache' => false,
            'auto_reload' => true,
        ]);
    },

];