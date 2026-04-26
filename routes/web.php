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

// Edité y añadí más Rutas de Usuarios:
//Muestra la lista
$router->get('usuarios', 'UserController@index');
//muestra el formulario de nuevo usuario
$router->get('usuarios/crear', 'UserController@create');
//guarda el usuario en la base de datos
$router->post('usuarios/crear', 'UserController@store');
//muestra el formulario con los datos de ese usuario para editar
$router->get('usuarios/editar', 'UserController@edit');
//actualiza el usuario en la base de datos
$router->post('usuarios/editar', 'UserController@update');
//borra el usuario de la base de datos
$router->post('usuarios/eliminar', 'UserController@delete');

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