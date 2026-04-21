<?php
// app/Controllers/UserController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Models\User;

class UserController extends Controller {
    
    public function index() {
        // 1. Protección: Solo usuarios logueados entran aquí
        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }

        // (Opcional) Más adelante aquí verificaremos si el usuario tiene rol de "Admin" para poder ver esta pantalla.

        // 2. Pedimos todos los usuarios al modelo
        $usuarios = User::getAll();

        // 3. Renderizamos la vista pasándole los datos
        $this->render('users/index', ['usuarios' => $usuarios]);
    }
}