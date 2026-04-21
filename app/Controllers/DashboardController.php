<?php
// app/Controllers/DashboardController.php
namespace app\Controllers;

use app\Core\Controller;

class DashboardController extends Controller { 
    
    public function index() {
        // --- PROTECCIÓN DE RUTA ---
        // Si no existe la variable de sesión, lo pateamos al login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }

        // Datos simulados (restaurados correctamente)
        $kpis = [
            'tickets_abiertos' => 14,
            'proyectos_activos' => 3,
            'tramites_pendientes' => 7
        ];

        // Renderizamos la vista
        $this->render('dashboard/index', ['kpis' => $kpis]);
    }
}