<?php

namespace app\Models;

use app\Core\database;
use PDO;

class User {

    public static function all() {
        $db = Database::getInstance()->getConnection();

        $sql = "SELECT u.*, r.nombre AS rol_nombre
                FROM usuarios u
                INNER JOIN roles r ON u.rol_id = r.id"
                WHERE u.deleted_at IS NULL";

        return $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("
        SELECT u.*, r.nombre AS rol_nombre 
        FROM usuarios u 
        INNER JOIN roles r ON u.rol_id = r.id 
        WHERE u.id = ? AND u.deleted_at IS NULL
    ");

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("
            INSERT INTO usuarios (nombre, email, password, rol_id, empresa_id, telefono, estado)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['rol_id'],
            $data['empresa_id'],
            $data['telefono'],
            $data['estado']
        ]);
    }

    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();

        $sql = "UPDATE usuarios SET nombre=?, email=?, rol_id=?, telefono=?, estado=?";

        $params = [
            $data['nombre'],
            $data['email'],
            $data['rol_id'],
            $data['telefono'],
            $data['estado']
        ];

        if (isset($data['password'])) {
            $sql .= ", password=?";
            $params[] = $data['password'];
        }

        $sql .= " WHERE id=?";
        $params[] = $id;

        $stmt = $db->prepare($sql);

        return $stmt->execute($params);
    }

    public static function delete($id) {
    $db = Database::getInstance()->getConnection();

    $stmt = $db->prepare("
        UPDATE usuarios 
        SET deleted_at = NOW() 
        WHERE id = ?
    ");

    return $stmt->execute([$id]);
}
}