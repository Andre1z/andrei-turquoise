<?php
/**
 * insert_sample_data.php
 *
 * Este script inserta 15 registros de ejemplo en las tablas 'restaurants' y 'reservations'
 * utilizando datos definidos en un archivo JSON llamado "sample_data.json".
 *
 * Procedimiento:
 *   1. Lee y decodifica el archivo JSON.
 *   2. Inserta los registros en 'restaurants' y almacena sus IDs.
 *   3. Inserta los registros en 'reservations' asignando el id_restaurant basado en el orden del JSON.
 *   4. Actualiza el campo 'id_reservation' en 'restaurants' para relacionar cada restaurante
 *      con su correspondiente reserva.
 *
 * Nota: Asegúrate de haber creado previamente las tablas 'restaurants' y 'reservations'
 *       y de que la clave foránea en 'restaurants' apunte a 'reservations'.
 */

// Ruta del archivo JSON (se asume que el archivo se llama "sample_data.json" y se encuentra en la misma carpeta)
$jsonFile = __DIR__ . '/sample_data.json';

if (!file_exists($jsonFile)) {
    die("El archivo sample_data.json no existe.");
}

$jsonData = file_get_contents($jsonFile);
$data = json_decode($jsonData, true);

if ($data === null) {
    die("Error al decodificar el archivo JSON.");
}

if (!isset($data['restaurants']) || !isset($data['reservations'])) {
    die("El archivo JSON debe contener las claves 'restaurants' y 'reservations'.");
}

// Ruta absoluta al archivo de la base de datos
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Conectar a la base de datos SQLite
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Activar soporte para claves foráneas
    $pdo->exec("PRAGMA foreign_keys = ON");

    // -------------------------------------------------------------------------
    // 1. Insertar datos en la tabla 'restaurants'
    // -------------------------------------------------------------------------
    $stmtRestaurant = $pdo->prepare("
        INSERT INTO restaurants (restaurant_name, direction, email, phone)
        VALUES (:restaurant_name, :direction, :email, :phone)
    ");

    $restaurantIds = [];
    foreach ($data['restaurants'] as $restaurant) {
        $stmtRestaurant->execute([
            ':restaurant_name' => $restaurant['restaurant_name'],
            ':direction'       => $restaurant['direction'],
            ':email'           => $restaurant['email'],
            ':phone'           => $restaurant['phone']
        ]);
        $restaurantIds[] = $pdo->lastInsertId();
    }
    echo "15 registros insertados en la tabla 'restaurants'.\n";

    // -------------------------------------------------------------------------
    // 2. Insertar datos en la tabla 'reservations'
    // -------------------------------------------------------------------------
    // Se asigna cada reserva al restaurante correspondiente (por el orden de los arrays)
    $stmtReservation = $pdo->prepare("
        INSERT INTO reservations (id_restaurant, client_name)
        VALUES (:id_restaurant, :client_name)
    ");

    $reservationIds = [];
    $i = 0;
    foreach ($data['reservations'] as $reservation) {
        $id_restaurant = isset($restaurantIds[$i]) ? $restaurantIds[$i] : null;
        $stmtReservation->execute([
            ':id_restaurant' => $id_restaurant,
            ':client_name'   => $reservation['client_name']
        ]);
        $reservationIds[] = $pdo->lastInsertId();
        $i++;
    }
    echo "15 registros insertados en la tabla 'reservations'.\n";

    // -------------------------------------------------------------------------
    // 3. Actualizar el campo 'id_reservation' en la tabla 'restaurants'
    // -------------------------------------------------------------------------
    $stmtUpdate = $pdo->prepare("
        UPDATE restaurants 
        SET id_reservation = :reservation_id 
        WHERE id = :restaurant_id
    ");
    
    for ($i = 0; $i < count($restaurantIds); $i++) {
        if (isset($reservationIds[$i])) {
            $stmtUpdate->execute([
                ':reservation_id' => $reservationIds[$i],
                ':restaurant_id'  => $restaurantIds[$i]
            ]);
        }
    }
    echo "Campo 'id_reservation' de 'restaurants' actualizado correctamente.\n";

} catch (PDOException $e) {
    die("Error al insertar datos de ejemplo: " . $e->getMessage());
}