<?php

// controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\AuthController;

// todo: make functions also a callables in the container invoker resolver
// so I can use view()

$router = new AltoRouter();
$router->setBasePath('/marketplace');

// define routes ->
$router->map('GET', '/', [HomeController::class, 'index']);
$router->map('GET', '/market', [MarketController::class, 'index']);
//$router->map('GET', '/user', [\App\Http\Controllers\UserController::class, 'get']);

// auth::start
// views
$router->map('GET', '/user/register', fn () => twig('user/register'));
$router->map('GET', '/user/login', fn () => twig('user/login'));

// actions
$router->map('POST', '/user/register', [AuthController::class, 'actionRegister']);
$router->map('POST', '/user/login', [AuthController::class, 'actionLogin']);
$router->map('GET', '/user/profile', [AuthController::class, 'profile']);
$router->map('GET', '/user/logout', [AuthController::class, 'logout']);
// auth::end


// register
// $router->map('GET', '/user/register', fn () => twig('/user/register'));
// $router->map('POST', '/user/register', [AuthController::class, 'actionRegister']);

// // login
// $router->map('GET', '/user/login', twig('/user/login'));
// $router->map('POST', '/user/login', [AuthController::class, 'actionLogin']);

// // profile
// $router->map('GET', '/user/profile', [AuthController::class, 'profile']);

// // logout
// $router->map('GET', '/user/logout', [AuthController::class, 'logout']);
// auth::end