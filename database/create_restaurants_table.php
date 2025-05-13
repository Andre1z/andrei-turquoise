<?php
/**
 * create_restaurants_table.php
 *
 * Script para crear la tabla 'restaurants' en la base de datos SQLite.
 * La tabla 'restaurants' contendrá: id, restaurant_name, direction, email, phone,
 * y id_reservation como clave foránea hacia reservations(id).
 */

// Ruta del archivo de la base de datos
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Conectar a la base de datos SQLite
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la tabla 'reservations' sin la restricción de clave foránea
    $sql = "
        CREATE TABLE IF NOT EXISTS reservations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            id_restaurant INTEGER,
            client_name TEXT NOT NULL,
            date TEXT DEFAULT CURRENT_TIMESTAMP
        );
    ";

    $pdo->exec($sql);
    echo "Tabla 'reservations' creada exitosamente (sin foreign keys).";
} catch (PDOException $e) {
    die("Error al crear la tabla 'reservations': " . $e->getMessage());
}