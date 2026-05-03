<?php
use app\Controllers\AuthController;
use app\Controllers\DashboardController;
use app\Controllers\ProjectController;
use app\Controllers\UserController;

// --- RUTAS PÚBLICAS ---
$router->get('login', [AuthController::class, 'showLogin']);
$router->post('login', [AuthController::class, 'login']);
$router->get('logout', [AuthController::class, 'logout']);
$router->get('/', [AuthController::class, 'showLogin']); 
$router->get('', [AuthController::class, 'showLogin']); 
$router->get('lang', [DashboardController::class, 'setLanguage']); 

// --- RUTAS PROTEGIDAS ---
$router->get('dashboard', [DashboardController::class, 'index']);
$router->get('proyectos', [ProjectController::class, 'index']);
$router->get('proyectos/crear', [ProjectController::class, 'create']);
$router->post('proyectos/crear', [ProjectController::class, 'store']);
$router->get('tickets', [\app\Controllers\TicketController::class, 'index']);
$router->get('tickets/crear', [\app\Controllers\TicketController::class, 'create']);
$router->post('tickets/crear', [\app\Controllers\TicketController::class, 'store']);
$router->get('chat', [\app\Controllers\ChatController::class, 'index']);
$router->get('chat/getMessages', [\app\Controllers\ChatController::class, 'getMessages']);
$router->post('chat/send', [\app\Controllers\ChatController::class, 'send']);

// Gestión de Usuarios
$router->get('users', [UserController::class, 'index']);
$router->get('users/create', [UserController::class, 'create']);
$router->post('users/create', [UserController::class, 'store']);
$router->get('users/edit', [UserController::class, 'edit']);
$router->post('users/edit', [UserController::class, 'update']);
$router->post('users/delete', [UserController::class, 'delete']);