<?php
// public/index.php

// 1. Iniciamos sesiones (necesario para el login más adelante)
session_start();

// 2. Definimos constantes para no escribir rutas larguísimas
define('BASE_PATH', dirname(__DIR__)); // Apunta a la carpeta raíz 'gestor-pro'
define('APP_PATH', BASE_PATH . '/app');
define('VIEWS_PATH', BASE_PATH . '/views');

// 3. Autocargador de clases (Autoloader)
// Esto evita que tengamos que hacer "require_once" por cada archivo nuevo que creemos.
spl_autoload_register(function ($class) {
    // Convierte el namespace (app\Core\Router) en una ruta de archivo (app/Core/Router.php)
    $class = str_replace('\\', '/', $class);
    $file = BASE_PATH . '/' . $class . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// 4. Cargamos el archivo de rutas
require_once BASE_PATH . '/routes/web.php';