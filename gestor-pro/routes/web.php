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
$router->get('usuarios', 'UserController@index');
$router->get('usuarios/crear', 'UserController@create');
$router->post('usuarios/crear', 'UserController@store');
$router->get('usuarios/editar', 'UserController@edit');
$router->post('usuarios/editar', 'UserController@update');
$router->post('usuarios/eliminar', 'UserController@delete');

// --- 2. LUEGO CAPTURAMOS LA URL ---
$uri = isset($_GET['route']) ? $_GET['route'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// --- 3. AL FINAL DE TODO DESPACHAMOS ---
$router->dispatch($uri, $method);