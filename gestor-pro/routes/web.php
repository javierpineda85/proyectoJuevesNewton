<?php
// routes/web.php
use app\Core\Router;

$router = new Router();

// --- 1. PRIMERO REGISTRAMOS TODAS LAS RUTAS ---
$router->get('/', 'DashboardController@index');
$router->get('dashboard', 'DashboardController@index');

// Rutas de Autenticación
$router->get('login', 'AuthController@showLogin');
$router->post('login', 'AuthController@login'); 

// Rutas de Usuarios (edito para aplicar las rutas según los cambios que hice en el index.php de usuarios)
$router->get('users', 'UserController@index');
$router->get('users/create', 'UserController@create');
$router->post('users/create', 'UserController@store');
$router->get('users/edit', 'UserController@edit');
$router->post('users/edit', 'UserController@update');
$router->post('users/delete', 'UserController@delete');

// --- 2. LUEGO CAPTURAMOS LA URL ---
$uri = isset($_GET['route']) ? $_GET['route'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// --- 3. AL FINAL DE TODO DESPACHAMOS ---
$router->dispatch($uri, $method);