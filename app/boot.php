<?php 

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

// class aliases
use DI\Container;

// app services->
require_once __DIR__ . '/services/database.php';
require_once __DIR__ . '/services/session.php';

require_once __DIR__ . '/routes/web.php'; // <-- essentials - routes

// route handler
global $router;
$match = $router->match();

if ($match && is_array($match['target'])) {
    // target details
    [$class, $method] = $match['target'];

    // resolve controller
    try {
        $container = new Container();
        $controller = $container->get($class);
    } catch (\Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        exit;
    }

    // Call the controller method with route params
    call_user_func_array([$controller, $method], $match['params']);
} else { // not found --->

    // 404 handler
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 - Page not found';

}
