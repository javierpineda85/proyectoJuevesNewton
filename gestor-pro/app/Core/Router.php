<?php
// app/Core/Router.php
namespace app\Core;

class Router {
    private $routes = [];

    // Método para registrar rutas tipo GET (visitar una página)
    public function get($uri, $controllerAction) {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    // Método para registrar rutas tipo POST (enviar un formulario)
    public function post($uri, $controllerAction) {
        $this->routes['POST'][$uri] = $controllerAction;
    }

    // Método que ejecuta la ruta actual
    public function dispatch($uri, $method) {
        // Limpiamos la URL por si viene con basura
        $uri = trim($uri, '/');
        if ($uri === '') $uri = '/'; // Si está vacía, es la ruta principal

        if (array_key_exists($uri, $this->routes[$method])) {
            // Separa "DashboardController@index" en dos variables
            $action = $this->routes[$method][$uri];
            list($controller, $methodName) = explode('@', $action);
            
            // Llama a la clase del controlador dinámicamente
            $controllerClass = "app\\Controllers\\" . $controller;
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $methodName)) {
                    return $controllerInstance->$methodName(); // Ejecuta el método
                } else {
                    die("Error 500: Método '$methodName' no encontrado en $controller.");
                }
            } else {
                die("Error 500: Controlador '$controller' no encontrado.");
            }
        } else {
            die("Error 404: La ruta '$uri' no existe en el sistema.");
        }
    }
}