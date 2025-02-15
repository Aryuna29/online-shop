<?php
class App
{

    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'userController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'userController',
                'method' => 'registrate',
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'userController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'userController',
                'method' => 'login',
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => 'userController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'userController',
                'method' => 'profile',
            ]
        ],
        '/editedProfile' => [
            'GET' => [
                'class' => 'userController',
                'method' => 'profileEdited',
            ],
            'POST' => [
                'class' => 'userController',
                'method' => 'profileEdited',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'productController',
                'method' => 'catalog',
            ],
            'POST' => [
                'class' => 'productController',
                'method' => 'catalog',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'productController',
                'method' => 'cart',
            ],
            'POST' => [
                'class' => 'productController',
                'method' => 'cart',
            ]
        ]

    ];
public function run()
{

    $requesUri = $_SERVER['REQUEST_URI'];
    $requestMethod  = $_SERVER['REQUEST_METHOD'];

    $routeMethods = $this->routes[$requesUri];
    $handler = $routeMethods[$requestMethod];
    $class = $handler['class'];
    $method = $handler['method'];
    $controller = new $class();
    $controller->$method();
    //else {
    //    http_response_code(404);
     //   require_once '../public/404.php';
    }

//require_once '../Core/App.php';
//$app = new App();
//$app->run();

}