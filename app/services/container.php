<?php 

use DI\ContainerBuilder;
use Invoker\Invoker;
use Invoker\ParameterResolver\AssociativeArrayResolver;
use Invoker\ParameterResolver\Container\TypeHintContainerResolver;
use Invoker\ParameterResolver\NumericArrayResolver;
use Invoker\ParameterResolver\DefaultValueResolver;
use Invoker\ParameterResolver\ResolverChain;


// build container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(require_once __DIR__ . '/../config/di.php');
$containerBuilder->useAutowiring(true);

$container = $containerBuilder->build();

// invoker
$parameterResolvers = [
    new AssociativeArrayResolver(),
    new TypeHintContainerResolver($container),
    new NumericArrayResolver(),
    new DefaultValueResolver(),
];

$resolverChain = new ResolverChain($parameterResolvers);
$invoker = new Invoker($resolverChain, $container);