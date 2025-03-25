<?php

namespace Core;

use Service\Logger\LoggerBDService;
use Service\Logger\LoggerInterface;
use Service\Logger\LoggerService;

class App
{
    private LoggerInterface $loggerService;
    private array $routes = [];
    public function __construct()
    {
        $this->loggerService = new LoggerService();
    }
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

            $requestClass = $handler['request'];
            try {
                if ($requestClass !== null) {
                    $request = new $requestClass($_POST);
                    $controller->$method($request);
                } else {
                    $controller->$method();
                }
            } catch (\Throwable $exception) {
               $this->loggerService->log($exception);
            }
        } else {
            echo "$requestMethod не поддерживается для $requestUri";
        }
    } else {
        http_response_code(404);
        require_once '../Views/404.php';
    }

    }

    public function get(string $route, string $className, string $method, string $requestClass = null)
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }
    public function post(string $route, string $className, string $method, string $requestClass = null)
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }

    public function put(string $route, string $className, string $method)
    {
        $this->routes[$route]['PUT'] = [
            'class' => $className,
            'method' => $method,
        ];
    }
    public function delete(string $route, string $className, string $method)
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $className,
            'method' => $method,
        ];
    }
}