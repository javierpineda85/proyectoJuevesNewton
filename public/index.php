<?php
// public/index.php

// 1. Configuración estricta de seguridad de Sesiones ANTES de iniciar cualquier output
ini_set('session.use_only_cookies', 1); // Evitar fijación de sesión por URL
ini_set('session.cookie_httponly', 1);  // Proteger la cookie contra robo por JavaScript (XSS)
ini_set('session.use_strict_mode', 1);  // Rechazar session IDs no inicializados por el servidor

define('VIEWS_PATH', __DIR__ . '/../views');


// Habilitar 'cookie_secure' si estamos en un entorno HTTPS
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

// 2. Carga del framework y dependencias
require_once __DIR__ . '/../app/Config/Config.php';
require_once __DIR__ . '/../app/Core/Session.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/I18n.php';
require_once __DIR__ . '/../app/Core/Controller.php';
require_once __DIR__ . '/../app/Core/Router.php';

// Inicializar Variables de Env (.env)
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

// Iniciar sistema de sesiones
\app\Core\Session::init();

// 3. Inicializar el Router y mapear Rutas
$router = new app\Core\Router();
require_once __DIR__ . '/../routes/web.php';

// 3.5 Global Helpers
function url($path = '') {
    return \app\Config\Config::baseUrl($path);
}

function redirect($path = '') {
    header("Location: " . url($path));
    exit;
}

// 4. Procesamiento de la URI (Front Controller)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajuste dinámico para WAMP y subcarpetas
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // e.g. /proyectos/proyecto/public
$baseDir = str_replace('/public', '', $scriptDir); // e.g. /proyectos/proyecto
$uri = str_replace($baseDir, '', $uri);
$uri = str_replace('/public', '', $uri); // Por si acaso se incluye /public en la URL

$method = $_SERVER['REQUEST_METHOD'];


// Disparar la ruta
$router->dispatch($uri, $method);