<?php

use app\Core\Router;

use app\Controllers\DashboardController;
use app\Controllers\AuthController;
use app\Controllers\UserController;
use app\Controllers\ProjectController;
use app\Controllers\TicketController;

$router = new Router();

// Dashboard
$router->get('/', [DashboardController::class, 'index']);
$router->get('dashboard', [DashboardController::class, 'index']);

// Auth
$router->get('login', [AuthController::class, 'showLogin']);
$router->post('login', [AuthController::class, 'login']);

// Usuarios
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

// Proyectos
$router->get('proyectos', [ProjectController::class, 'index']);

$router->get('proyectos/crear', [ProjectController::class, 'create']);
$router->post('proyectos/crear', [ProjectController::class, 'store']);

$router->get('proyectos/editar', [ProjectController::class, 'edit']);
$router->post('proyectos/update', [ProjectController::class, 'update']);

// Tickets
$router->get('tickets', [TicketController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);

$router->get('tickets/crear', [TicketController::class, 'create'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);

$router->post('tickets/crear', [TicketController::class, 'store'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);

// Dispatch
$uri = isset($_GET['route']) ? $_GET['route'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);