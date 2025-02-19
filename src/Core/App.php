<?php

namespace Core;
class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'profile',
            ]
        ],
        '/editedProfile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'profileEdited',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'profileEdited',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'catalog',
            ],
            'POST' => [
                'class' => 'ProductController',
'method' => 'catalog',]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'cart',
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'cart',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'order',
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'order',
            ]
        ]
    ];
public function run()
{

    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod  = $_SERVER['REQUEST_METHOD'];

    if (isset($this->routes[$requestUri])) {
        $routeMethods = $this->routes[$requestUri];
        if (isset($routeMethods[$requestMethod])) {
            $handler = $routeMethods[$requestMethod];

           $class = $handler['class'];
            $method = $handler['method'];

          //  require_once "../Controllers/{$class}.php";

            $controller = new \Controllers\ProductController();
            $controller->$method();
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
    } else {
        http_response_code(404);
        require_once '../Views/404.php';
    }

    }

}