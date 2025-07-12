<?php

// controllers
use App\Http\Controllers\HomeController;

$router = new AltoRouter();
$router->setBasePath('/marketplace');

// define routes ->
$router->map('GET', '/', [HomeController::class, 'index']);
$router->map('GET', '/about', [HomeController::class, 'about']);
$router->map('GET', '/user/[i:id]', [HomeController::class, 'user']);
