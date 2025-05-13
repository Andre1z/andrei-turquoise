<?php
// app/core/Database.php

class Database {
    /**
     * Instancia única de la conexión PDO.
     *
     * @var Database|null
     */
    private static $instance = null;

    /**
     * Objeto PDO que representa la conexión a la base de datos.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructor privado para evitar instanciación directa.
     */
    private function __construct() {
        // Se asume que en config/config.php se definen las siguientes constantes:
        // Para SQLite: DB_DRIVER, DB_PATH
        // Para MySQL (u otros): DB_HOST, DB_NAME, DB_USER, DB_PASS

        if (DB_DRIVER === 'sqlite') {
            // DSN para SQLite: se utiliza la ruta absoluta al archivo de la base de datos
            $dsn = 'sqlite:' . DB_PATH;
            try {
                $this->pdo = new PDO($dsn);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos (SQLite): " . $e->getMessage());
            }
        } else {
            // DSN para MySQL (u otros), en caso de que se requiera en el futuro
            $host     = DB_HOST;
            $dbname   = DB_NAME;
            $username = DB_USER;
            $password = DB_PASS;
            $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

            try {
                $this->pdo = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos (MySQL): " . $e->getMessage());
            }
        }
        
        // Configurar PDO para lanzar excepciones y obtener resultados en forma de objeto
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * Retorna la instancia única de la clase Database.
     *
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * Devuelve la conexión PDO.
     *
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }

    // Prevenir clonación y deserialización de la instancia.
    private function __clone() {}
    private function __wakeup() {}
}