<?php

function twig(string $template, array $data = []): string
{
    global $container;

    // bind session dynamically to ensure flash messages are available
    $twig = $container->get(\Twig\Environment::class);
    $twig->addGlobal('session', $_SESSION ?? []);

    return $twig->render("{$template}.twig", $data);
}

function redirect(string $url = '', array $flash = []): void {
    // Set flash messages if provided
    if (!empty($flash)) {
        \Amrudinbalic\Marketplace\Http\Session::startIfNotActive();

        foreach ($flash as $type => $message) {
            $_SESSION['flash'][$type] = $message;
        }
    }
    
    http_response_code(302);
    header("Location: /marketplace/{$url}");
    exit;
}

function config(string $key) {

    $requested = explode('.', $key);
    $config = require __DIR__ . '/../app/config/' . $requested[0] . '.php'; // get a config file

    if(count($requested) > 1) {
        $config = $config[$requested[1]];
    }

    return $config;
}