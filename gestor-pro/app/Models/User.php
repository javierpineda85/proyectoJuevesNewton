<?php
namespace app\Models;

use app\Core\Database;
use PDO;

class User {
    
    // Lo usa el login
    public static function findByEmail($email) {
        $db = Database::getInstancia();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Lista todos los usuarios
    public static function getAll() {
        $db = Database::getInstancia();
        $stmt = $db->query("SELECT id, nombre, email, rol, telefono FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca uno por ID
    public static function find($id) {
        $db = Database::getInstancia();
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Crea usuario nuevo
    public static function create($data) {
        $db = Database::getInstancia();
        $sql = "INSERT INTO usuarios (nombre, email, password, rol, telefono) 
                VALUES (:nombre, :email, :password, :rol, :telefono)";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    // Actualiza usuario
    public static function update($data) {
        $db = Database::getInstancia();
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, rol = :rol, telefono = :telefono WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($data);
    }

    // Elimina usuario
    public static function delete($id) {
        $db = Database::getInstancia();
        $stmt = $db->prepare("DELETE FROM usuarios WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}