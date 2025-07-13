<?php

// max error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

// class aliases
use DI\ContainerBuilder;
use Invoker\Invoker;
use Invoker\ParameterResolver\Container\TypeHintContainerResolver;
use Invoker\ParameterResolver\AssociativeArrayResolver;
use Invoker\ParameterResolver\DefaultValueResolver;
use Invoker\ParameterResolver\NumericArrayResolver;
use Invoker\ParameterResolver\ResolverChain;

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

    // build container
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions(require __DIR__ . '/../app/config/di.php');
    $containerBuilder->useAutowiring(true);

    try {
        $container = $containerBuilder->build();
        
        $parameterResolvers = [
            new AssociativeArrayResolver(),
            new TypeHintContainerResolver($container),
            new NumericArrayResolver(),
            new DefaultValueResolver(),
        ];
        
        $resolverChain = new ResolverChain($parameterResolvers);
        $invoker = new Invoker($resolverChain, $container);

        // get results
        $controller = $container->get($class);
        $response = $invoker->call([$controller, $method], $match['params'] ?? []);

        // return response
        echo $response;
        exit;

    } catch (\Exception $e) {
        http_response_code(500);
        echo $e->getMessage();
        exit;
    }

} else { // not found --->

    // 404 handler
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo '404 - Page not found';

}
