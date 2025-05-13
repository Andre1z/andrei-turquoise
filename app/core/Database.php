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
        // Se espera que en config/config.php se definan estas constantes:
        // DB_HOST, DB_NAME, DB_USER, DB_PASS
        $host     = DB_HOST;
        $dbname   = DB_NAME;
        $username = DB_USER;
        $password = DB_PASS;

        // DSN para conectar a una base de datos MySQL
        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            // Configurar que PDO lance excepciones en caso de error
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configurar el modo de obtención de resultados (objetos)
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // En producción, es recomendable registrar el error en lugar de mostrarlo directamente
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
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

    // Prevenir que se clonen o deserialicen instancias de la clase Database
    private function __clone() {}
    private function __wakeup() {}
}