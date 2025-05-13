<?php
// public/create_reservation.php

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

// Obtener la lista de restaurantes
$stmtRestaurants = $db->query("SELECT id, restaurant_name FROM restaurants");
$restaurantsList = $stmtRestaurants->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = trim($_POST['client_name'] ?? '');
    $id_restaurant = trim($_POST['id_restaurant'] ?? '');
    
    if (empty($client_name) || empty($id_restaurant)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $db->prepare("INSERT INTO reservations (id_restaurant, client_name) VALUES (:id_restaurant, :client_name)");
        $stmt->execute([
            ':id_restaurant' => $id_restaurant,
            ':client_name' => $client_name
        ]);
        // Opcional: Actualizar el campo id_reservation en el restaurante seleccionado con el ID de la nueva reserva
        $newReservationId = $db->lastInsertId();
        $updateStmt = $db->prepare("UPDATE restaurants SET id_reservation = :reservation_id WHERE id = :restaurant_id");
        $updateStmt->execute([
            ':reservation_id' => $newReservationId,
            ':restaurant_id' => $id_restaurant
        ]);
        header("Location: index.php?page=restaurants");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Reserva - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
   <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=dashboard">Dashboard</a></li>
                <li><a href="index.php?page=restaurants" class="active">Restaurantes</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
   </header>
   <main>
       <section>
           <h2>Crear Reserva</h2>
           <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>
           <form method="post" action="">
               <div class="form-group">
                   <label for="client_name">Nombre del Cliente:</label>
                   <input type="text" name="client_name" id="client_name" required>
               </div>
               <div class="form-group">
                   <label for="id_restaurant">Restaurante:</label>
                   <select name="id_restaurant" id="id_restaurant" required>
                       <option value="">Seleccione un restaurante</option>
                       <?php foreach ($restaurantsList as $rest): ?>
                           <option value="<?php echo htmlspecialchars($rest['id']); ?>">
                               <?php echo htmlspecialchars($rest['restaurant_name']); ?>
                           </option>
                       <?php endforeach; ?>
                   </select>
               </div>
               <div class="form-group">
                   <input type="submit" value="Crear Reserva">
               </div>
           </form>
       </section>
   </main>
   <footer>
       <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
   </footer>
</body>
</html>