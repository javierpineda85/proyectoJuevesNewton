<?php
// app/Models/User.php
namespace app\Models;

use app\Core\Database;
use PDO;

class User {
    
    // Método estático para buscar un usuario por su email
    public static function findByEmail($email) {
        $db = Database::getInstancia();
        
        // Preparamos la consulta con :email (Nunca concatenar variables directamente)
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        
        // Ejecutamos pasando el parámetro
        $stmt->execute(['email' => $email]);
        
        // Retornamos el array asociativo del usuario (o false si no existe)
        return $stmt->fetch();
    }

    // Método para obtener todos los usuarios con su rol
    public static function getAll() {
        $db = Database::getInstancia();
        // Hacemos un JOIN con la tabla roles para obtener el nombre del rol
        $sql = "SELECT u.id, u.nombre, u.email, u.estado, r.nombre AS rol_nombre 
                FROM usuarios u 
                INNER JOIN roles r ON u.rol_id = r.id 
                ORDER BY u.id DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // busca el usuario, prepara la consulta, ejecuta y devuelve el resultado de los usuarios:
    public static function find($id) {
    $db = Database::getInstancia();
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

public static function create($data) {
    $db = Database::getInstancia();
    $sql = "INSERT INTO usuarios (nombre, email, password, rol_id, estado) 
            VALUES (:nombre, :email, :password, :rol_id, :estado)";
    $stmt = $db->prepare($sql);
    return $stmt->execute($data);
}

public static function update($data) {
    $db = Database::getInstancia();
    $sql = "UPDATE usuarios 
            SET nombre = :nombre, email = :email, rol_id = :rol_id, estado = :estado 
            WHERE id = :id";
    $stmt = $db->prepare($sql);
    return $stmt->execute($data);
}

public static function delete($id) {
    $db = Database::getInstancia();
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = :id");
    return $stmt->execute(['id' => $id]);
}

public static function getRoles() {
    $db = Database::getInstancia();
    $stmt = $db->query("SELECT * FROM roles");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}