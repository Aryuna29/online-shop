<?php

namespace Core;
class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getRegistrate',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'registrate',
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'login',
            ]
        ],
        '/profile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'profile',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'profile',
            ]
        ],
        '/editedProfile' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'profileEdited',
            ],
            'POST' => [
                'class' => '\Controllers\UserController',
                'method' => 'profileEdited',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => '\Controllers\ProductController',
                'method' => 'catalog',
            ],
            'POST' => [
                'class' => '\Controllers\ProductController',
'method' => 'catalog',]
        ],
        '/cart' => [
            'GET' => [
                'class' => '\Controllers\ProductController',
                'method' => 'cart',
            ],
            'POST' => [
                'class' => '\Controllers\ProductController',
                'method' => 'cart',
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => '\Controllers\UserController',
                'method' => 'logout',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => '\Controllers\OrderController',
                'method' => 'order',
            ],
            'POST' => [
                'class' => '\Controllers\OrderController',
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

            $controller = new $class;
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