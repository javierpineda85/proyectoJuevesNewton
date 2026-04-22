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

// Rutas de Usuarios
$router->get('usuarios', 'UserController@index');

// Rutas de Proyectos
$router->get('proyectos', 'ProjectController@index');
//Rutas de Creacion de Proyectos
$router->get('proyectos/crear', 'ProjectController@create');
$router->post('proyectos/crear', 'ProjectController@store');
//Rutas de Edicion de Proyectos
$router->get('proyectos/editar', 'ProjectController@edit');
$router->post('proyectos/editar', 'ProjectController@update');

// --- 2. LUEGO CAPTURAMOS LA URL ---
$uri = isset($_GET['route']) ? $_GET['route'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// --- 3. AL FINAL DE TODO DESPACHAMOS ---
$router->dispatch($uri, $method);