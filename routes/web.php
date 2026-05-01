<?php
// routes/web.php

use app\Controllers\AuthController;
use app\Controllers\DashboardController;
use app\Controllers\ProjectController;

// --- RUTAS PÚBLICAS ---
$router->get('login', [AuthController::class, 'showLogin']);
$router->post('login', [AuthController::class, 'login']);
$router->get('logout', [AuthController::class, 'logout']);
$router->get('/', [AuthController::class, 'showLogin']); 
$router->get('', [AuthController::class, 'showLogin']); 
$router->get('lang', [DashboardController::class, 'setLanguage']); 

// --- RUTAS PROTEGIDAS (RBAC) ---

// Dashboard Principal
$router->get('dashboard', [DashboardController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);

// Gestión de Proyectos
$router->get('proyectos', [ProjectController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado']
]);
$router->get('proyectos/crear', [ProjectController::class, 'create'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo']
]);
$router->post('proyectos/crear', [ProjectController::class, 'store'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo']
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

// Mensajería Interna
$router->get('chat', [\app\Controllers\ChatController::class, 'index'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);
$router->get('chat/getMessages', [\app\Controllers\ChatController::class, 'getMessages'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);
$router->post('chat/send', [\app\Controllers\ChatController::class, 'send'], [
    'AuthMiddleware' => ['admin', 'directivo', 'administrativo', 'empleado', 'cliente']
]);