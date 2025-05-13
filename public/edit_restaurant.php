<?php
// public/edit_restaurant.php

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
    die("No se proporcionó el ID del restaurante.");
}

$id = intval($_GET['id']);

// Procesar formulario cuando se envíe el POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_name = trim($_POST['restaurant_name'] ?? '');
    $direction = trim($_POST['direction'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($restaurant_name) || empty($direction) || empty($email) || empty($phone)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $db->prepare("UPDATE restaurants SET restaurant_name = :restaurant_name, direction = :direction, email = :email, phone = :phone WHERE id = :id");
        $stmt->execute([
            ':restaurant_name' => $restaurant_name,
            ':direction'       => $direction,
            ':email'           => $email,
            ':phone'           => $phone,
            ':id'              => $id
        ]);
        header("Location: index.php?page=restaurants");
        exit;
    }
} else {
    // Obtener datos del restaurante
    $stmt = $db->prepare("SELECT * FROM restaurants WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$restaurant) {
        die("Restaurante no encontrado.");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Restaurante - <?php echo APP_NAME; ?></title>
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
           <h2>Editar Restaurante</h2>
           <?php if (isset($error)) echo '<p style="color:red;">' . $error . '</p>'; ?>
           <form method="post" action="">
               <div class="form-group">
                   <label for="restaurant_name">Nombre:</label>
                   <input type="text" name="restaurant_name" id="restaurant_name" value="<?php echo htmlspecialchars($restaurant['restaurant_name']); ?>" required>
               </div>
               <div class="form-group">
                   <label for="direction">Dirección:</label>
                   <input type="text" name="direction" id="direction" value="<?php echo htmlspecialchars($restaurant['direction']); ?>" required>
               </div>
               <div class="form-group">
                   <label for="email">Email:</label>
                   <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($restaurant['email']); ?>" required>
               </div>
               <div class="form-group">
                   <label for="phone">Teléfono:</label>
                   <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($restaurant['phone']); ?>" required>
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