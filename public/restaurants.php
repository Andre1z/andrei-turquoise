<?php
// public/restaurants.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

$db = Database::getInstance()->getConnection();

// Consultar todos los restaurantes
$stmt = $db->query("SELECT * FROM restaurants");
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consultar todas las reservas
$stmt2 = $db->query("SELECT * FROM reservations");
$reservations = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Restaurantes y Reservas - <?php echo APP_NAME; ?></title>
    <!-- Estilos globales -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Estilos específicos para secciones de restaurantes y reservas -->
    <link rel="stylesheet" href="css/restaurants.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=dashboard">Dashboard</a></li>
                <li><a href="index.php?page=profile">Perfil</a></li>
                <li><a href="index.php?page=restaurants" class="active">Restaurantes</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Botones para crear nuevos registros -->
        <div class="action-links">
            <a href="index.php?page=create_restaurant">Crear Restaurante</a>
            <a href="index.php?page=create_reservation">Crear Reserva</a>
        </div>
        <section>
            <h2>Lista de Restaurantes</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>ID Reserva</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($restaurants as $restaurant): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($restaurant['id']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['restaurant_name']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['direction']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['email']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['phone']); ?></td>
                        <td><?php echo htmlspecialchars($restaurant['id_reservation']); ?></td>
                        <td class="actions">
                            <a href="index.php?page=edit_restaurant&id=<?php echo $restaurant['id']; ?>">Editar</a>
                            <a href="index.php?page=delete_restaurant&id=<?php echo $restaurant['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este restaurante?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Lista de Reservas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Restaurante</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['id_restaurant']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['client_name']); ?></td>
                        <td><?php echo htmlspecialchars($reservation['date']); ?></td>
                        <td class="actions">
                            <a href="index.php?page=edit_reservation&id=<?php echo $reservation['id']; ?>">Editar</a>
                            <a href="index.php?page=delete_reservation&id=<?php echo $reservation['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta reserva?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>