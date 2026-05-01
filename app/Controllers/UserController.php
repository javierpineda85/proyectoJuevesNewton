<?php
// app/Controllers/UserController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;
use app\Models\User;
use app\Core\Database;

class UserController extends Controller {
    
    public function index() {
        Session::checkRole(['admin', 'directivo', 'administrativo']);
        
        $usuarios = User::getAll();
        $this->render('users/index', ['usuarios' => $usuarios]);
    }

    public function create() {
        Session::checkRole(['admin', 'directivo']);
        
        $db = Database::getInstancia();
        $roles = $db->query("SELECT * FROM roles")->fetchAll();

        $this->render('users/create', ['roles' => $roles]);
    }

    public function store() {
        Session::checkRole(['admin', 'directivo']);

        $data = [
            'empresa_id' => Session::get('empresa_id'),
            'rol_id'     => $_POST['rol_id'],
            'nombre'     => trim($_POST['nombre']),
            'email'      => trim($_POST['email']),
            'password'   => $_POST['password'],
            'telefono'   => trim($_POST['telefono']),
            'estado'     => $_POST['estado'] ?? 'activo'
        ];

        if (User::create($data)) {
            redirect('usuarios');
            exit;
        } else {
            die("Error al crear el usuario.");
        }
    }

    public function edit() {
        Session::checkRole(['admin', 'directivo']);
        $id = $_GET['id'] ?? 0;

        $usuario = User::findById($id);
        if (!$usuario) {
            redirect('usuarios');
            exit;
        }

        $db = Database::getInstancia();
        $roles = $db->query("SELECT * FROM roles")->fetchAll();

        $this->render('users/edit', [
            'usuario' => $usuario,
            'roles' => $roles
        ]);
    }

    public function update() {
        Session::checkRole(['admin', 'directivo']);
        $id = $_GET['id'] ?? 0;

        $data = [
            'rol_id'     => $_POST['rol_id'],
            'nombre'     => trim($_POST['nombre']),
            'email'      => trim($_POST['email']),
            'telefono'   => trim($_POST['telefono']),
            'estado'     => $_POST['estado']
        ];

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        if (User::update($id, $data)) {
            redirect('usuarios');
            exit;
        } else {
            die("Error al actualizar el usuario.");
        }
    }

    public function delete() {
        Session::checkRole(['admin', 'directivo']);
        $id = $_POST['id'] ?? 0;
        User::delete($id);
        redirect('usuarios');
        exit;
    }
}