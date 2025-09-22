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

    /**
     * Despacha a rota requisitada, executando o callback associado.
     * @throws \Exception Se a rota não for encontrada.
     */
    public function dispatch(string $route, string $method = 'GET')
    {
        // Remove query parameters da URL para fazer o match correto
        $cleanRoute = strtok($route, '?');

        // Verifica se a rota é para um recurso estático
        $this->checksForResourceRequest($cleanRoute);

        // Verifica se a rota contém um ID numérico
        if (
            preg_match('/\d+/', $cleanRoute) &&
            !empty($this->routes[$method][preg_replace('/\d+/', '{id}', $cleanRoute)])
        ) {
            $callback = $this->routes[$method][preg_replace('/\d+/', '{id}', $cleanRoute)];
            $args = preg_match('/\d+/', $cleanRoute, $matches) ? $matches[0] : null;
        } elseif (empty($this->routes[$method][$cleanRoute])) {
            // exit;
            // Verifica se a rota existe, caso contrário, usa a rota principal ou lança exceção
            if (isset($this->routes[$method][$this->mainRoute])) {
                header("Location: {$this->mainRoute}", true, 302);
                exit;
            } else {
                throw new \Exception("No route found for {$method} {$cleanRoute}");
            }
        } else {
            // Executa o callback associado à rota
            $callback = $this->routes[$method][$cleanRoute];
        }

        if (is_callable($callback)) {
            return call_user_func($callback);
        } elseif (is_array($callback) && count($callback) === 2) {
            $controller = Application::getContainer()->get($callback[0]);
            $methodName = $callback[1];
            if (method_exists($controller, $methodName)) {
                return call_user_func([$controller, $methodName], $args ?? null);
            }
        }
    }

    /**
     * Verifica se a rota requisitada é para um recurso estático (CSS, JS, imagens).
     */
    public function checksForResourceRequest(string $route): void
    {
        if (strpos($route, '/resources/') === 0) {
            $filePath = realpath(__DIR__ . '/../resources/' . str_replace('/resources/', '', $route));

            if ($filePath && file_exists($filePath) && is_file($filePath)) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                $mimeTypes = [
                    'css'  => 'text/css',
                    'js'   => 'application/javascript',
                    'png'  => 'image/png',
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif'  => 'image/gif',
                    'svg'  => 'image/svg+xml'
                ];

                $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

                header("Content-Type: {$mimeType}");
                readfile($filePath);
                exit;
            } else {
                http_response_code(404);
                echo "Resource not found.";
                exit;
            }
        }
    }
}
