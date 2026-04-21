<?php
// app/Controllers/AuthController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Models\User;

class AuthController extends Controller {
    
    public function showLogin() {
        $this->render('auth/login', [], 'auth');
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        // Si el usuario existe y la contraseña es correcta
        if ($user && password_verify($password, $user['password'])) {
            
            // Creamos la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol_id'];
            
            // Redirigimos al panel
            header("Location: /proyectos/gestor-pro/public/dashboard");
            exit;
            
        } else {
            $this->render('auth/login', ['error' => 'Correo o contraseña incorrectos.'], 'auth');
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: /proyectos/gestor-pro/public/login");
        exit;
    }
}