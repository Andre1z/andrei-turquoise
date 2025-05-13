<?php
/**
 * insert_sample_data.php
 *
 * Este script inserta 15 registros de ejemplo en las tablas 'restaurants' y 'reservations'
 * utilizando datos definidos explícitamente en el código.
 *
 * Procedimiento:
 *   1. Inserta 15 registros en 'restaurants'.
 *   2. Inserta 15 registros en 'reservations'.
 *   3. Actualiza el campo 'id_reservation' en 'restaurants' para relacionar cada restaurante
 *      con su correspondiente reserva.
 *
 * Nota: Asegúrate de haber creado previamente las tablas 'restaurants' y 'reservations'
 *       mediante sus respectivos scripts.
 */

// Ruta absoluta al archivo de la base de datos
$databasePath = __DIR__ . '/database.sqlite';

try {
    // Conectar a la base de datos SQLite
    $pdo = new PDO("sqlite:" . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Activar soporte para claves foráneas
    $pdo->exec("PRAGMA foreign_keys = ON");

    // -------------------------------------------------------------------------
    // 1. Datos de ejemplo para la tabla 'restaurants'
    // -------------------------------------------------------------------------
    $restaurants = [
        [
            'restaurant_name' => 'La Buena Mesa',
            'direction'       => 'Calle Mayor 123, Valencia',
            'email'           => 'contacto@labuenamesa.com',
            'phone'           => '600111111'
        ],
        [
            'restaurant_name' => 'Sabor Mediterráneo',
            'direction'       => 'Av. del Mar 456, Valencia',
            'email'           => 'info@sabormediterraneo.com',
            'phone'           => '600222222'
        ],
        [
            'restaurant_name' => 'El Rincón del Chef',
            'direction'       => 'Plaza de España 789, Valencia',
            'email'           => 'reservas@rincondelchef.com',
            'phone'           => '600333333'
        ],
        [
            'restaurant_name' => 'Restaurante El Prado',
            'direction'       => 'Calle Real 10, Valencia',
            'email'           => 'contacto@prado.com',
            'phone'           => '600444444'
        ],
        [
            'restaurant_name' => 'Casa de Tapas',
            'direction'       => 'Calle de las Tapas 5, Valencia',
            'email'           => 'info@casadetapas.com',
            'phone'           => '600555555'
        ],
        [
            'restaurant_name' => 'El Fogón',
            'direction'       => 'Av. de la Paz 18, Valencia',
            'email'           => 'reservas@elfogon.com',
            'phone'           => '600666666'
        ],
        [
            'restaurant_name' => 'La Terraza',
            'direction'       => 'Calle del Sol 2, Valencia',
            'email'           => 'contacto@laterraza.com',
            'phone'           => '600777777'
        ],
        [
            'restaurant_name' => 'Restaurante La Viña',
            'direction'       => 'Av. de los Olivos 12, Valencia',
            'email'           => 'info@lavina.com',
            'phone'           => '600888888'
        ],
        [
            'restaurant_name' => 'El Jardín',
            'direction'       => 'Calle de las Flores 22, Valencia',
            'email'           => 'reservas@eljardin.com',
            'phone'           => '600999999'
        ],
        [
            'restaurant_name' => 'Café Gourmet',
            'direction'       => 'Avenida Gourmet 33, Valencia',
            'email'           => 'contacto@cafegourmet.com',
            'phone'           => '601000000'
        ],
        [
            'restaurant_name' => 'La Bodega',
            'direction'       => 'Calle de la Bodega 44, Valencia',
            'email'           => 'info@labodega.com',
            'phone'           => '601111111'
        ],
        [
            'restaurant_name' => 'El Sabor Auténtico',
            'direction'       => 'Plaza del Sabor 55, Valencia',
            'email'           => 'reservas@elsabor.com',
            'phone'           => '601222222'
        ],
        [
            'restaurant_name' => 'Cocina y Vino',
            'direction'       => 'Calle del Vino 66, Valencia',
            'email'           => 'contacto@cocinayvino.com',
            'phone'           => '601333333'
        ],
        [
            'restaurant_name' => 'El Paladar',
            'direction'       => 'Av. Paladar 77, Valencia',
            'email'           => 'info@elpaladar.com',
            'phone'           => '601444444'
        ],
        [
            'restaurant_name' => 'Bistró Moderno',
            'direction'       => 'Calle Moderna 88, Valencia',
            'email'           => 'reservas@bistro.com',
            'phone'           => '601555555'
        ]
    ];

    $stmtRestaurant = $pdo->prepare("
        INSERT INTO restaurants (restaurant_name, direction, email, phone)
        VALUES (:restaurant_name, :direction, :email, :phone)
    ");
    
    $restaurantIds = [];
    // Insertar cada restaurante y guardar su id
    foreach ($restaurants as $restaurant) {
        $stmtRestaurant->execute($restaurant);
        $restaurantIds[] = $pdo->lastInsertId();
    }
    echo "15 registros insertados en la tabla 'restaurants'.\n";

    // -------------------------------------------------------------------------
    // 2. Datos de ejemplo para la tabla 'reservations'
    // -------------------------------------------------------------------------
    $reservations = [
        ['id_restaurant' => $restaurantIds[0],  'client_name' => 'Juan Pérez'],
        ['id_restaurant' => $restaurantIds[1],  'client_name' => 'María García'],
        ['id_restaurant' => $restaurantIds[2],  'client_name' => 'Carlos López'],
        ['id_restaurant' => $restaurantIds[3],  'client_name' => 'Ana Martínez'],
        ['id_restaurant' => $restaurantIds[4],  'client_name' => 'José Ramírez'],
        ['id_restaurant' => $restaurantIds[5],  'client_name' => 'Laura Fernández'],
        ['id_restaurant' => $restaurantIds[6],  'client_name' => 'Pedro Sánchez'],
        ['id_restaurant' => $restaurantIds[7],  'client_name' => 'Marta Díaz'],
        ['id_restaurant' => $restaurantIds[8],  'client_name' => 'Luis Gómez'],
        ['id_restaurant' => $restaurantIds[9],  'client_name' => 'Carmen Ortega'],
        ['id_restaurant' => $restaurantIds[10], 'client_name' => 'Sergio Ruiz'],
        ['id_restaurant' => $restaurantIds[11], 'client_name' => 'Patricia Moreno'],
        ['id_restaurant' => $restaurantIds[12], 'client_name' => 'Rafael Jiménez'],
        ['id_restaurant' => $restaurantIds[13], 'client_name' => 'Elena Torres'],
        ['id_restaurant' => $restaurantIds[14], 'client_name' => 'David Fernández']
    ];

    $stmtReservation = $pdo->prepare("
        INSERT INTO reservations (id_restaurant, client_name)
        VALUES (:id_restaurant, :client_name)
    ");
    
    $reservationIds = [];
    // Insertar cada reserva y almacenar su id
    foreach ($reservations as $reservation) {
        $stmtReservation->execute($reservation);
        $reservationIds[] = $pdo->lastInsertId();
    }
    echo "15 registros insertados en la tabla 'reservations'.\n";

    // -------------------------------------------------------------------------
    // 3. Actualizar el campo 'id_reservation' en 'restaurants'
    // -------------------------------------------------------------------------
    $stmtUpdate = $pdo->prepare("
        UPDATE restaurants 
        SET id_reservation = :reservation_id 
        WHERE id = :restaurant_id
    ");
    
    // Se asigna a cada restaurante la reserva correspondiente (índice 0 a 14)
    for ($i = 0; $i < count($restaurantIds); $i++) {
        $stmtUpdate->execute([
            ':reservation_id' => $reservationIds[$i],
            ':restaurant_id'  => $restaurantIds[$i]
        ]);
    }
    echo "Campo 'id_reservation' de 'restaurants' actualizado correctamente.\n";

} catch (PDOException $e) {
    die("Error al insertar datos de ejemplo: " . $e->getMessage());
}