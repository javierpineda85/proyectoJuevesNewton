<?php
// app/Models/Project.php
namespace app\Models;

use app\Core\Database;
use PDO;

class Project {
    
    public static function getAll() {
        $db = Database::getInstancia();
        $sql = "SELECT p.*, u.nombre AS empleado_asignado 
                FROM proyectos p 
                LEFT JOIN usuarios u ON p.asignado_a = u.id 
                ORDER BY p.fecha_limite ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NUEVO: Buscar un proyecto por ID
    public static function find($id) {
        $db = Database::getInstancia();
        $stmt = $db->prepare("SELECT * FROM proyectos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // NUEVO: Guardar un nuevo proyecto
    public static function create($data) {
        $db = Database::getInstancia();
        $sql = "INSERT INTO proyectos (titulo, descripcion, estado, fecha_limite, creador_id, asignado_a) 
                VALUES (:titulo, :descripcion, :estado, :fecha_limite, :creador_id, :asignado_a)";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    //Actualizar un proyecto existente
    public static function update($data) {
        $db = Database::getInstancia();
        $sql = "UPDATE proyectos 
                SET titulo = :titulo, 
                    descripcion = :descripcion, 
                    estado = :estado, 
                    fecha_limite = :fecha_limite, 
                    asignado_a = :asignado_a 
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }
}