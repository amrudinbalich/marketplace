<?php

/**
 * Dependency Injection Container
 * Place the complex-dependencies constructor definitions here.
 * If a service/class requires a bit more steps to be initialized, you can define it here.
 * 
 * What happens next?
 * When your service, under defined alias is being called on desired place (controller for example) -
 * container 'will know' how to initialize your service, and it will automatically inject it into your class.
 */

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

        return $twig;
    },

    // PDO/DB
    PDO::class => fn() => (new Connect())->getConnection(),

];