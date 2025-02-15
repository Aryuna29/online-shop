<?php

$requesUri = $_SERVER['REQUEST_URI'];
$requestMethod  = $_SERVER['REQUEST_METHOD'];

if ($requesUri === '/profile') {
    require_once '../Controllers/UserController.php';
    $user = new userController();
    if ($requestMethod === 'GET') {
        $user->profile();
    } elseif ($requestMethod === 'POST') {
        $user->profile();
    }
}elseif ($requesUri === '/editedProfile') {
    require_once '../Controllers/UserController.php';
    $user = new userController();
        if ($requestMethod === 'GET') {
            $user->profileEdited();
        } elseif ($requestMethod === 'POST') {
            $user->profileEdited();
        }
} elseif ($requesUri === '/registration') {
    require_once '../Controllers/UserController.php';
    $user = new userController();
    if ($requestMethod === 'GET') {
       $user->getRegistrate();
    } elseif ($requestMethod === 'POST') {
       $user->registrate();
    }

}elseif ($requesUri === '/login') {
    require_once '../Controllers/UserController.php';
    $user = new userController();
    if ($requestMethod === 'GET') {
        $user->getLogin();
    } elseif ($requestMethod === 'POST') {
       $user->login();
    }
} elseif ($requesUri === '/catalog') {
    require_once '../Controllers/ProductController.php';
    $products = new productController();
    if ($requestMethod === 'GET') {
        $products->catalog();
    } elseif ($requestMethod === 'POST') {
        $products->catalog();
    }
} elseif ($requesUri === '/cart') {
    require_once '../Controllers/ProductController.php';
    $products = new productController();
    if ($requestMethod === 'GET') {
        $products->cart();
    } elseif ($requestMethod === 'POST') {
        $products->cart();
    }
} else {
    http_response_code(404);
require_once './404.php';
}
