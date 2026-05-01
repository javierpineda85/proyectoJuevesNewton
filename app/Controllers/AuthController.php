<?php
// app/Controllers/AuthController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;

// Carga manual preventiva del modelo
require_once __DIR__ . '/../Models/User.php';
use app\Models\User;


class AuthController extends Controller {
    
    public function showLogin() {
        if (Session::isLoggedIn()) {
            redirect('dashboard');
            exit;
        }
        $this->render('auth/login', [], 'auth');
    }

    public function login() {
        $this->validateCsrf();

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $this->render('auth/login', ['error' => 'Por favor complete todos los campos.'], 'auth');
            return;
        }

        // Llamada estricta al modelo User
        $user = User::findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['estado'] !== 'activo') {
                $this->render('auth/login', ['error' => 'Su cuenta está inactiva.'], 'auth');
                return;
            }

            session_regenerate_id(true);

            Session::set('user_id', $user['id']);
            Session::set('user_name', $user['nombre']);
            Session::set('rol_id', $user['rol_id']);
            Session::set('rol_nombre', $user['rol_nombre']);
            Session::set('empresa_id', $user['empresa_id']);
            
            redirect('dashboard');
            exit;
            
        } else {
            $this->render('auth/login', ['error' => 'Credenciales incorrectas.'], 'auth');
        }
    }
    
    public function logout() {
        Session::destroy();
        redirect('login');
        exit;
    }
}