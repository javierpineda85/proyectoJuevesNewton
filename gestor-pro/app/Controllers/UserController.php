<?php
namespace app\Controllers;

use app\Core\Controller;
use app\Models\User;

class UserController extends Controller {
    
    // Lista todos los usuarios
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }
        $usuarios = User::getAll();
        $this->render('users/index', ['usuarios' => $usuarios]);
    }

    // Muestra formulario de nuevo usuario
    public function create() {
        $this->render('users/create', []);
    }

    // Guarda usuario nuevo
    public function store() {
        $data = [
            'nombre'   => trim($_POST['nombre']),
            'email'    => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'rol'      => $_POST['rol'],
            'telefono' => trim($_POST['telefono'] ?? '')
        ];

        if (User::create($data)) {
            header("Location: /proyectos/gestor-pro/public/users");
            exit;
        } else {
            die("Error al crear el usuario.");
        }
    }

    // Muestra formulario de edición
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $usuario = User::find($id);

        if (!$usuario) {
            header("Location: /proyectos/gestor-pro/public/users");
            exit;
        }

        $this->render('users/edit', ['usuario' => $usuario]);
    }

    // Guarda cambios
    public function update() {
        $data = [
            'id'       => $_GET['id'] ?? 0,
            'nombre'   => trim($_POST['nombre']),
            'email'    => trim($_POST['email']),
            'rol'      => $_POST['rol'],
            'telefono' => trim($_POST['telefono'] ?? '')
        ];

        if (User::update($data)) {
            header("Location: /proyectos/gestor-pro/public/users");
            exit;
        } else {
            die("Error al actualizar el usuario.");
        }
    }

    // Elimina usuario
    public function delete() {
        $id = $_GET['id'] ?? 0;
        User::delete($id);
        header("Location: /proyectos/gestor-pro/public/users");
        exit;
    }
}