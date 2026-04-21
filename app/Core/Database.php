<?php
// app/Core/Database.php
namespace app\Core;

use PDO;
use PDOException;

// Requerimos las constantes
require_once __DIR__ . '/../Config/config.php';

class Database {
    private static $instancia = null;
    private $conexion;

    // El constructor es privado para evitar que se creen múltiples conexiones
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $opciones = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Manejo estricto de errores
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Nos devuelve arrays asociativos limpios
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Seguridad máxima contra Inyección SQL
        ];

        try {
            $this->conexion = new PDO($dsn, DB_USER, DB_PASS, $opciones);
        } catch (PDOException $e) {
            // En producción, aquí se guarda un log. Por ahora, mostramos el error.
            die("Error crítico de Base de Datos: " . $e->getMessage());
        }
    }

    // Método para obtener la instancia única de la conexión
    public static function getInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia->conexion;
    }
}