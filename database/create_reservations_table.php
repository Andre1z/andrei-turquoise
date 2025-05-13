<?php
/**
 * create_reservations_table.php
 *
 * Este script crea la tabla 'reservations' en la base de datos SQLite.
 * La tabla tendrá las siguientes columnas:
 *   - id            : INTEGER PRIMARY KEY AUTOINCREMENT
 *   - id_restaurant : INTEGER, llave foránea que referencia restaurants(id)
 *   - client_name   : TEXT NOT NULL
 *   - date          : TEXT, registra la fecha actual del registro (por defecto CURRENT_TIMESTAMP)
 *
 * Nota: Asegúrate de que la tabla 'restaurants' exista previamente para que la llave foránea funcione.
 */

// Ruta absoluta al archivo de la base de datos (ajusta la ruta si es necesario)
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Conectar a la base de datos SQLite
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Activar el soporte de claves foráneas en SQLite
    $pdo->exec("PRAGMA foreign_keys = ON");

    // SQL para crear la tabla 'reservations'
    $sql = "
        CREATE TABLE IF NOT EXISTS reservations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            id_restaurant INTEGER,
            client_name TEXT NOT NULL,
            date TEXT DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_restaurant) REFERENCES restaurants(id)
        );
    ";

    // Ejecutar la instrucción SQL para crear la tabla
    $pdo->exec($sql);

    echo "Tabla 'reservations' creada exitosamente en la base de datos.";
} catch (PDOException $e) {
    die("Error al crear la tabla 'reservations': " . $e->getMessage());
}