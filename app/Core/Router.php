<?php

namespace app\Core;

class Router {

    private $routes = [];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method) {

        $uri = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            echo "Error 404 - Página no encontrada";
            return;
        }

        list($controllerName, $methodName) = explode('@', $this->routes[$method][$uri]);

        $controllerClass = "Controllers\\$controllerName";

        require_once "../Controllers/$controllerName.php";

        $controller = new $controllerClass();

        call_user_func([$controller, $methodName]);
    }
}