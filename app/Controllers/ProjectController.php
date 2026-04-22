<?php
// app/Controllers/ProjectController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Models\Project;
use app\Models\User; 

class ProjectController extends Controller {
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }
        $proyectos = Project::getAll();
        $this->render('projects/index', ['proyectos' => $proyectos]);
    }

    public function create() {
        $usuarios = User::getAll(); 
        $this->render('projects/create', ['usuarios' => $usuarios]);
    }

    public function store() {
        $titulo = trim($_POST['titulo']);
        $fecha_limite = $_POST['fecha_limite'];
        $hoy = date('Y-m-d');

        if (empty($titulo)) {
            die("Error: El título es obligatorio.");
        }

        if ($fecha_limite < $hoy) {
            die("Error Crítico: No puedes asignar una fecha límite en el pasado.");
        }

        $data = [
            'titulo' => $titulo,
            'descripcion' => trim($_POST['descripcion']),
            'estado' => $_POST['estado'],
            'fecha_limite' => $fecha_limite,
            'creador_id' => $_SESSION['user_id'], 
            'asignado_a' => !empty($_POST['asignado_a']) ? $_POST['asignado_a'] : null
        ];

        if (Project::create($data)) {
            header("Location: /proyectos/gestor-pro/public/proyectos");
            exit;
        } else {
            die("Error en la base de datos al crear el proyecto.");
        }
    }

    // Muestra el formulario de edición pre-rellenado
    public function edit() { 

        $id = $_GET['id'] ?? 0;

        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }

        $proyecto = Project::find($id);
        
        if (!$proyecto) {
            header("Location: /proyectos/gestor-pro/public/proyectos");
            exit;
        }

        $usuarios = User::getAll(); 

        $this->render('projects/edit', ['proyecto' => $proyecto, 'usuarios' => $usuarios]);
    }

    // Procesa la actualización (POST)
    public function update() { 
        
        $id = $_GET['id'] ?? 0;
        
        $titulo = trim($_POST['titulo']);
        $fecha_limite = $_POST['fecha_limite'];

        if (empty($titulo)) {
            die("Error: El título es obligatorio.");
        }

        $data = [
            'id' => $id, 
            'titulo' => $titulo,
            'descripcion' => trim($_POST['descripcion']),
            'estado' => $_POST['estado'],
            'fecha_limite' => $fecha_limite,
            'asignado_a' => !empty($_POST['asignado_a']) ? $_POST['asignado_a'] : null
        ];

        if (Project::update($data)) {
            header("Location: /proyectos/gestor-pro/public/proyectos");
            exit;
        } else {
            die("Error al actualizar el proyecto.");
        }
    }
}