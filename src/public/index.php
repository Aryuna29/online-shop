<?php

use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
\Core\Autoloader::register($path);

$app = new \Core\App();
$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrate');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');
$app->addRoute('/OrderUsers', 'GET', OrderController::class, 'getUserOrder');
$app->addRoute('/create-order', 'GET', OrderController::class, 'getCheckoutForm');
$app->addRoute('/create-order', 'POST', OrderController::class, 'handleCheckout');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/cart', 'GET', ProductController::class, 'cart');
$app->addRoute('/cart', 'POST', ProductController::class, 'cart');
$app->addRoute('/catalog', 'GET', ProductController::class, 'catalog');
$app->addRoute('/catalog', 'POST', ProductController::class, 'catalog');
$app->addRoute('/editedProfile', 'GET', UserController::class, 'profileEdited');
$app->addRoute('/editedProfile', 'POST', UserController::class, 'profileEdited');
$app->addRoute('/profile', 'GET', UserController::class, 'profile');
$app->addRoute('/profile', 'POST', UserController::class, 'profile');
$app->addRoute('/login', 'GET', UserController::class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');

$app->run();
