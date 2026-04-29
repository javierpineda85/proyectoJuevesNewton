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

    // Mostrar formulario de nuevo usuario
    public function create() {
        $roles = User::getRoles();
        $this->render('users/create', ['roles' => $roles]);
    }

    // Guardar nuevo usuario en la base de datos
    public function store() {
        $data = [
            'nombre'   => trim($_POST['nombre']),
            'email'    => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'rol_id'   => $_POST['rol_id'],
            'estado'   => $_POST['estado']
        ];

        if (User::create($data)) {
            header("Location: /proyectos/gestor-pro/public/usuarios");
            exit;
        } else {
            die("Error al crear el usuario.");
        }
    }

    // Mostrar formulario de edición con datos del usuario
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $usuario = User::find($id);
        $roles = User::getRoles();

        if (!$usuario) {
            header("Location: /proyectos/gestor-pro/public/usuarios");
            exit;
        }

        $this->render('users/edit', ['usuario' => $usuario, 'roles' => $roles]);
    }

    // Guardar cambios del usuario editado
    public function update() {
        $data = [
            'id'     => $_GET['id'] ?? 0,
            'nombre' => trim($_POST['nombre']),
            'email'  => trim($_POST['email']),
            'rol_id' => $_POST['rol_id'],
            'estado' => $_POST['estado']
        ];

        if (User::update($data)) {
            header("Location: /proyectos/gestor-pro/public/usuarios");
            exit;
        } else {
            die("Error al actualizar el usuario.");
        }
    }

    // Eliminar usuario
    public function delete() {
        $id = $_GET['id'] ?? 0;
        User::delete($id);
        header("Location: /proyectos/gestor-pro/public/usuarios");
        exit;
    }
}