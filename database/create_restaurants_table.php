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
    
    // Activar las claves foráneas en SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    // SQL para crear la tabla 'restaurants' con la referencia correcta a "reservations"
    $sql = "
        CREATE TABLE IF NOT EXISTS restaurants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            restaurant_name TEXT NOT NULL,
            direction TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            id_reservation INTEGER,
            FOREIGN KEY (id_reservation) REFERENCES reservations(id)
        );
    ";

    // Ejecutar la instrucción SQL para crear la tabla
    $pdo->exec($sql);

    echo "Tabla 'restaurants' creada exitosamente en la base de datos.";
} catch (PDOException $e) {
    die("Error al crear la tabla 'restaurants': " . $e->getMessage());
}