<?php

namespace Core;

use  App\Enums\Method;
use App\Enums\Status;

class Router
{
    private array $routes = [];

    public function addRoute(string $uriPattern, string $controller, string $action, Method $method): void
    {
        $this->routes[] = [
            'uriPattern' => $uriPattern,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }

    public function dispatch(string $uri): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if (preg_match($route['uriPattern'], $uri, $matches) && $route['method']->value === $requestMethod) {
                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                $controller = new $controllerClass();

                if (method_exists($controller, 'before')) {
                    $controller->before();
                }

                $action = $route['action'];
                array_shift($matches); // видалити перший елемент, оскільки це буде весь URI
                call_user_func_array([$controller, $action], $matches);

                if (method_exists($controller, 'after')) {
                    $controller->after();
                }

                return;
            }
        }

        http_response_code(Status::NOT_FOUND->value);
        echo json_encode(['message' => 'Not Founjjd']);
    }
}
