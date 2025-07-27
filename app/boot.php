<?php

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

// class aliases
use Amrudinbalic\Marketplace\Http\Session;

// app services->
require_once __DIR__ . '/services/container.php';
require_once __DIR__ . '/services/session.php';
require_once __DIR__ . '/routes/web.php';

// route handler
global $router;
$match = $router->match();

if ($match && is_array($match['target'])) { // controller
    // target details
    [$class, $method] = $match['target'];

    try {

        // include dependencies
        global $container, $invoker;

        // get results
        $controller = $container->get($class);
        $response = $invoker->call([$controller, $method], $match['params'] ?? []);

        // return response (terminate steps)
        echo $response;
        Session::unsetFlashMessages();
        exit;

    } catch (\Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        exit;
    }

} elseif(is_callable($match['target'])) { // function

    $response = $match['target']($match['params'] ?? []);

    echo $response;
    Session::unsetFlashMessages();
    exit;

} else { // not found

    // 404 handler
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 - Page not found';
    exit;

}
