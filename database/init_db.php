<?php
/**
 * init_db.php
 *
 * Script para generar la base de datos SQLite 'database.sqlite' dentro de la carpeta /database.
 * Al ejecutarlo, se creará el archivo de base de datos (si no existe) y se crearán algunas tablas de ejemplo.
 */

// Ruta absoluta para el archivo de la base de datos
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Crear (o abrir) la conexión a la base de datos usando PDO
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL para crear la tabla 'users' si no existe. Puedes agregar más tablas aquí.
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

    // Ejecutar la creación de la tabla
    $pdo->exec($sql);

    echo "Base de datos y tablas creadas exitosamente en '$databasePath'.";
} catch (PDOException $e) {
    die("Error al crear la base de datos: " . $e->getMessage());
}