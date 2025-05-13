<?php
/**
 * create_restaurants_table.php
 *
 * Este script crea la tabla 'restaurants' en la base de datos SQLite.
 * La tabla 'restaurants' tendrá las siguientes columnas:
 *   - id            : INTEGER PRIMARY KEY AUTOINCREMENT
 *   - restaurant_name : TEXT NOT NULL
 *   - direction       : TEXT NOT NULL
 *   - email           : TEXT NOT NULL
 *   - phone           : TEXT NOT NULL
 *   - id_reservation  : INTEGER (clave foránea que referencia reservation(id))
 *
 * Asegúrate de que la tabla 'reservation' ya exista en la base de datos para que la clave foránea funcione correctamente.
 */

// Ruta del archivo de la base de datos. Puedes ajustarla según la estructura de tu proyecto.
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Conectar a la base de datos SQLite
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    // Activar las claves foráneas en SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    // SQL para crear la tabla 'restaurants'
    $sql = "
        CREATE TABLE IF NOT EXISTS restaurants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            restaurant_name TEXT NOT NULL,
            direction TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            id_reservation INTEGER,
            FOREIGN KEY (id_reservation) REFERENCES reservation(id)
        );
    ";

    // Ejecutar la instrucción para crear la tabla
    $pdo->exec($sql);

    echo "Tabla 'restaurants' creada exitosamente en la base de datos.";
} catch (PDOException $e) {
    die("Error al crear la tabla 'restaurants': " . $e->getMessage());
}