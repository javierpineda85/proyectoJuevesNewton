<?php
// app/Controllers/UserController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Core\Session;
use app\Models\User;
use app\Core\Database;

class UserController extends Controller {
    
    public function index() {
        Session::checkRole(['super_admin', 'administrativo']);

        $users = User::all();

        $this->render('users/index', ['users' => $users]);
    }

    public function create() {
        Session::checkRole(['super_admin']);

        $db = Database::getInstance()->getConnection();
        $roles = $db->query("SELECT * FROM roles")->fetchAll();

        $this->render('users/create', ['roles' => $roles]);
    }

    public function store() {
        Session::checkRole(['super_admin']);

        $data = [
            'empresa_id' => Session::get('empresa_id'),
            'rol_id'     => $_POST['rol_id'],
            'nombre'     => trim($_POST['nombre']),
            'email'      => trim($_POST['email']),
            'password'   => $_POST['password'],
            'telefono'   => trim($_POST['telefono']),
            'estado'     => $_POST['estado'] ?? 'activo'
        ];

        User::create($data);

        redirect('/usuarios');
    }

    public function edit() {
        Session::checkRole(['super_admin']);

        $id = $_GET['id'] ?? null;

        if (!$id) redirect('/usuarios');

        $user = User::findById($id);

        $db = Database::getInstance()->getConnection();
        $roles = $db->query("SELECT * FROM roles")->fetchAll();

        $this->render('users/edit', compact('user', 'roles'));
    }

    public function update() {
        Session::checkRole(['super_admin']);

        $id = $_GET['id'];

        $data = [
            'rol_id'     => $_POST['rol_id'],
            'nombre'     => trim($_POST['nombre']),
            'email'      => trim($_POST['email']),
            'telefono'   => trim($_POST['telefono']),
            'estado'     => $_POST['estado']
        ];

       if (!empty($_POST['password'])) {
            $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        User::update($id, $data);

        redirect('/usuarios');
    }

    public function delete() {
        Session::checkRole(['super_admin']);

        $id = $_POST['id'];

        User::delete($id);

        redirect('/usuarios');
    }
}