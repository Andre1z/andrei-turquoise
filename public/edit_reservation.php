<?php
// public/edit_reservation.php

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

if (!isset($_GET['id'])) {
    die("No se proporcionó el ID de la reserva.");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = trim($_POST['client_name'] ?? '');
    $id_restaurant = trim($_POST['id_restaurant'] ?? '');

    if (empty($client_name) || empty($id_restaurant)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $db->prepare("UPDATE reservations SET client_name = :client_name, id_restaurant = :id_restaurant WHERE id = :id");
        $stmt->execute([
            ':client_name'  => $client_name,
            ':id_restaurant'=> $id_restaurant,
            ':id'           => $id
        ]);
        header("Location: index.php?page=restaurants");
        exit;
    }
} else {
    $stmt = $db->prepare("SELECT * FROM reservations WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$reservation) {
        die("Reserva no encontrada.");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reserva - <?php echo APP_NAME; ?></title>
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
           <h2>Editar Reserva</h2>
           <?php if (isset($error)) echo '<p style="color:red;">'.$error.'</p>'; ?>
           <form method="post" action="">
               <div class="form-group">
                   <label for="client_name">Nombre del Cliente:</label>
                   <input type="text" name="client_name" id="client_name" value="<?php echo htmlspecialchars($reservation['client_name']); ?>" required>
               </div>
               <div class="form-group">
                   <label for="id_restaurant">ID Restaurante:</label>
                   <input type="number" name="id_restaurant" id="id_restaurant" value="<?php echo htmlspecialchars($reservation['id_restaurant']); ?>" required>
               </div>
               <div class="form-group">
                   <input type="submit" value="Actualizar">
               </div>
           </form>
       </section>
   </main>
   <footer>
       <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
   </footer>
</body>
</html>