<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Amrudinbalic\Marketplace\Database\Connect;

return [

    // Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../views');

        $twig = new Environment($loader, [
            'cache' => false,
            'auto_reload' => true,
        ]);
        $twig->addGlobal('session', $_SESSION);

        return $twig;
    },

    // PDO/DB
    PDO::class => fn() => (new Connect())->getConnection(),

];