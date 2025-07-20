<?php


function twig(string $template, array $data = []): string
{
    global $container;
    return $container->get(\Twig\Environment::class)->render("{$template}.twig", $data);
}

function redirect(string $url = '', array $flash = []): void {
    // Set flash messages if provided
    if (!empty($flash)) {
        if (!session_id()) {
            session_start();
        }
        foreach ($flash as $type => $message) {
            $_SESSION['flash'][$type] = $message;
        }
    }
    
    http_response_code(302);
    header("Location: /marketplace/{$url}");
    exit;
}