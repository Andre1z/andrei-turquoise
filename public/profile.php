<?php
// public/profile.php

require_once __DIR__ . '/../config/config.php';

// Inicia la sesión solo si aún no está activa.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está autenticado; de lo contrario, redirige a la página de login.
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

// Obtener la información del usuario desde la sesión.
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=dashboard">Dashboard</a></li>
                <li><a href="index.php?page=profile" class="active">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="profile-section">
            <h2>Perfil de Usuario</h2>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <!-- Puedes extender esta sección con más información o funcionalidades, como un formulario para actualizar datos -->
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>