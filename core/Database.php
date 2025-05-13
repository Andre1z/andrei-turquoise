<?php
// core/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Asumimos que el driver siempre es SQLite según la configuración actual
        $dsn = 'sqlite:' . DB_PATH;

        try {
            $this->pdo = new PDO($dsn);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos (SQLite): " . $e->getMessage());
        }

        // Configuramos PDO para lanzar excepciones
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    // __wakeup() debe ser público, pero en este caso puede quedar vacío
    public function __wakeup() {}

    // Impide la clonación
    private function __clone() {}
}
?>