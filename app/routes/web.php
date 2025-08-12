<?php

// ----------------------- WEB ROUTES -----------------------
// This file contains all the routes for this webapp, starting from the views ( plain and complex )
// to the controllers that are handling the operations logic and as a result returns views/redirections.
// ------------------------------------------------------------

// controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketController;

$router = new AltoRouter();
$router->setBasePath('/marketplace');

// ----------------------- VIEW LEGEND -----------------------
// twig() -> returns only a plain views, that dont need a data for rendering.
// If the view is more 'advanced' and needs data to be shown within it on the load -
// then it is rendered inside a controller
// ------------------------------------------------------------

// views
$router->map('GET', '/', fn () => twig('home'));

$router->map('GET', '/market', [MarketController::class, 'index']);
$router->map('POST', '/market/filter', [MarketController::class, 'filter']);

// market
$router->map('GET', '/market/article/[i:id]', [MarketController::class, 'article']); // article page
$router->map('GET', '/market/user/[i:id]', [MarketController::class, 'user']); // user profile
// $router->map('GET', '/market/user/inbox', [MarketController::class, 'inbox']); // user inbox
$router->map('GET', '/market/messages/[i:id]', [MarketController::class, 'messages']); // send inbox

// auth::start
// views
$router->map('GET', '/user/register', fn () => twig('user/register'));
$router->map('GET', '/user/login', fn () => twig('user/login'));

// actions
$router->map('POST', '/user/register', [AuthController::class, 'register']);
$router->map('POST', '/user/login', [AuthController::class, 'login']);

$router->map('GET', '/user/logout', [AuthController::class, 'logout']);

$router->map('GET', '/user/profile', [AuthController::class, 'profile']);
$router->map('GET', '/user/profile/settings', [AuthController::class, 'profileSettings']);

$router->map('GET', '/user/inbox', fn () => twig('user/inbox'));
// auth::end