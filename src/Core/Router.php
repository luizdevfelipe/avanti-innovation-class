<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $mainRoute = '/';

    public function get(string $route, callable|array $callback): void
    {
        $this->routeStore('GET', $route, $callback);
    }

    public function post(string $route, array $callback): void
    {
        $this->routeStore('POST', $route, $callback);
    }

    public function routeStore(string $method, string $route, array $callback): void
    {
        $this->routes[$method][$route] = $callback;
    }

    public function setMainRoute(string $route): void
    {
        $this->mainRoute = $route;
    }

    public function dispatch(string $route, string $method = 'GET')
    {
        // Remove query parameters da URL para fazer o match correto
        $cleanRoute = strtok($route, '?');

        // Verifica se a rota existe, caso contrário, usa a rota principal ou lança exceção
        if (!isset($this->routes[$method][$cleanRoute])) {
            if (isset($this->routes[$method][$this->mainRoute])) {
                header("Location: {$this->mainRoute}");
                exit;
            } else {
                throw new \Exception("No route found for {$method} {$cleanRoute}");
            }
        }
        // Executa o callback associado à rota
        $callback = $this->routes[$method][$cleanRoute];
        if (is_callable($callback)) {
            return call_user_func($callback);
        } elseif (is_array($callback) && count($callback) === 2) {
            $controller = Application::getContainer()->get($callback[0]);
            $methodName = $callback[1];
            if (method_exists($controller, $methodName)) {
                return call_user_func([$controller, $methodName]);
            }
        }
    }
}
