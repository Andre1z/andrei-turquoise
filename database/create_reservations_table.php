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

    // Crear la tabla 'restaurants' sin la restricción de clave foránea
    $sql = "
        CREATE TABLE IF NOT EXISTS restaurants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            restaurant_name TEXT NOT NULL,
            direction TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            id_reservation INTEGER
        );
    ";

    $pdo->exec($sql);
    echo "Tabla 'restaurants' creada exitosamente (sin foreign keys).";
} catch (PDOException $e) {
    die("Error al crear la tabla 'restaurants': " . $e->getMessage());
}