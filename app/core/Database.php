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
     * Esta implementación está diseñada exclusivamente para SQLite.
     */
    private function __construct() {
        // Verifica que el driver sea 'sqlite'
        if (DB_DRIVER !== 'sqlite') {
            die("Este proyecto está configurado para utilizar SQLite únicamente.");
        }

        // DSN para SQLite: se utiliza el archivo definido en DB_PATH (ubicado en database/migrations)
        $dsn = 'sqlite:' . DB_PATH;

        try {
            $this->pdo = new PDO($dsn);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos (SQLite): " . $e->getMessage());
        }
        
        // Configurar PDO para lanzar excepciones y obtener resultados como objetos
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

    // Evitar la clonación y deserialización de la instancia.
    private function __clone() {}
    private function __wakeup() {}
}