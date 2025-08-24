<?php

class Router
{
    private $routes = [];
    private $middlewares = [];

    public function addRoute($method, $path, $callback, $middlewares = [])
    {
        // Ensure middlewares is always an array
        if (!is_array($middlewares)) {
            $middlewares = [$middlewares];
        }
        $this->routes[] = compact('method', 'path', 'callback', 'middlewares');
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match("#^" . $route['path'] . "$#", $uri, $matches)) {
                array_shift($matches); // Remove o full match

                // Resolve o callback da rota
                $routeCallback = function () use ($route, $matches) {
                    call_user_func_array($route['callback'], $matches);
                };

                // Constrói a cadeia de middlewares
                $chain = array_reduce(
                    array_reverse($route['middlewares']),
                    function ($next, $middlewareName) {
                        // Verifica se a classe do middleware existe
                        if (!class_exists($middlewareName)) {
                            http_response_code(500);
                            echo json_encode(["message" => "Middleware '{$middlewareName}' não encontrado."]);
                            return function() {}; // Retorna um callable vazio para parar a cadeia
                        }
                        $middleware = new $middlewareName();
                        return function () use ($middleware, $next) {
                            $middleware->handle($next);
                        };
                    },
                    $routeCallback // O callback da rota é o último na cadeia
                );

                // Executa a cadeia de middlewares
                $chain();
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["message" => "Rota não encontrada."]);
    }
}
