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
$router->get('users', 'UserController@index');
//muestra el formulario de nuevo usuario
$router->get('users/create', 'UserController@create');
//guarda el usuario en la base de datos
$router->post('users/create', 'UserController@store');
//muestra el formulario con los datos de ese usuario para editar
$router->get('users/edit', 'UserController@edit');
//actualiza el usuario en la base de datos
$router->post('users/edit', 'UserController@update');
//borra el usuario de la base de datos
$router->post('users/delete', 'UserController@delete');

// Rutas de Proyectos
$router->get('proyectos', 'ProjectController@index');
//Rutas de Creacion de Proyectos
$router->get('proyectos/crear', 'ProjectController@create');
$router->post('proyectos/crear', 'ProjectController@store');
//Rutas de Edicion de Proyectos
$router->get('proyectos/editar', 'ProjectController@edit');
$router->post('proyectos/update', 'ProjectController@update');

<<<<<<< Updated upstream
// --- 2. LUEGO CAPTURAMOS LA URL ---
$uri = isset($_GET['route']) ? $_GET['route'] : '/';
$method = $_SERVER['REQUEST_METHOD'];
=======
//Gestión de Usuarios
use app\Controllers\UserController;

$router->get('users', [UserController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);
$router->get('users/create', [UserController::class, 'create'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);
$router->post('users/create', [UserController::class, 'store'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);
$router->get('users/edit', [UserController::class, 'edit'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);
$router->post('users/edit', [UserController::class, 'update'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);
$router->post('users/delete', [UserController::class, 'delete'], [
    'AuthMiddleware' => ['admin', 'superadmin', 'administrativo']
]);

// Gestión de Tickets
$router->get('tickets', [\app\Controllers\TicketController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);
$router->get('tickets/crear', [\app\Controllers\TicketController::class, 'create'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);
$router->post('tickets/crear', [\app\Controllers\TicketController::class, 'store'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);
>>>>>>> Stashed changes

// --- 3. AL FINAL DE TODO DESPACHAMOS ---
$router->dispatch($uri, $method);