<?php
// core/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        if (DB_DRIVER !== 'sqlite') {
            die("Este proyecto está configurado para usar SQLite únicamente.");
        }

        $dsn = 'sqlite:' . DB_PATH;

        try {
            $this->pdo = new PDO($dsn);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos (SQLite): " . $e->getMessage());
        }

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

    private function __clone() {}
    private function __wakeup() {}
}
?>