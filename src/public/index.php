<?php

use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
\Core\Autoloader::register($path);

$app = new \Core\App();
$app->get('/registration', UserController::class, 'getRegistrate');
$app->post('/registration', UserController::class, 'registrate');

$app->get('/OrderUsers', OrderController::class, 'getUserOrder');

$app->get('/create-order', OrderController::class, 'getCheckoutForm');
$app->post('/create-order', OrderController::class, 'handleCheckout');

$app->get('/logout', UserController::class, 'logout');

$app->get('/cart', ProductController::class, 'cart');
$app->post('/cart', ProductController::class, 'cart');

$app->get('/catalog', ProductController::class, 'catalog');


$app->post('/decrease', ProductController::class, 'decreaseProductCatalog');


$app->post('/add', ProductController::class, 'addProductCatalog');

$app->get('/editedProfile', UserController::class, 'getProfileEdited');
$app->post('/editedProfile', UserController::class, 'profileEdited');

$app->get('/profile', UserController::class, 'profile');

$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login');

$app->post('/product', ProductController::class, 'getProduct');
$app->post('/review-add', ProductController::class, 'addReviews');

$app->run();
