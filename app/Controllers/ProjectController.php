<?php
// app/Controllers/ProjectController.php
namespace app\Controllers;

use app\Core\Controller;
use app\Models\Project;
use app\Models\User; 

class ProjectController extends Controller {
    
    // 1. Mostrar todos los proyectos
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /proyectos/gestor-pro/public/login");
            exit;
        }
        $proyectos = Project::getAll();
        $this->render('projects/index', ['proyectos' => $proyectos]);
    }

    // 2. Mostrar formulario de nuevo proyecto
    public function create() {
        $usuarios = User::getAll(); 
        $this->render('projects/create', ['usuarios' => $usuarios]);
    }

    // 3. Guardar un nuevo proyecto (con archivos)
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

        $proyecto_id = Project::create($data);

        if ($proyecto_id) {
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['archivo']['tmp_name'];
                $fileName = $_FILES['archivo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'zip'];
                
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $newFileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $fileName);
                    $uploadFileDir = BASE_PATH . '/public/uploads/proyectos/';
                    $dest_path = $uploadFileDir . $newFileName;
                    
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        Project::addFile($proyecto_id, $fileName, $newFileName);
                    }
                }
            }
            header("Location: /proyectos/gestor-pro/public/proyectos");
            exit;
        } else {
            die("Error en la base de datos al crear el proyecto.");
        }
    }

    // 4. Mostrar formulario de edición pre-rellenado
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

        // Buscamos los archivos asociados a este proyecto
        $archivos = Project::getFiles($id);
        $usuarios = User::getAll(); 

        $this->render('projects/edit', [
            'proyecto' => $proyecto, 
            'usuarios' => $usuarios,
            'archivos' => $archivos
        ]);
    }

    // 5. Guardar cambios de edición (y nuevos archivos)
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
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['archivo']['tmp_name'];
                $fileName = $_FILES['archivo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'zip'];
                
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $newFileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $fileName);
                    $uploadFileDir = BASE_PATH . '/public/uploads/proyectos/';
                    $dest_path = $uploadFileDir . $newFileName;
                    
                    if(move_uploaded_file($fileTmpPath, $dest_path)) {
                        Project::addFile($id, $fileName, $newFileName);
                    }
                }
            }
            header("Location: /proyectos/gestor-pro/public/proyectos");
            exit;
        } else {
            die("Error al actualizar el proyecto.");
        }
    }
}