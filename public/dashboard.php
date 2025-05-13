<?php
// public/dashboard.php

require_once __DIR__ . '/../config/config.php';
session_start();

// Verificar si el usuario está logueado; en caso contrario, redirigir a login
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

// Obtener los datos del usuario de la sesión
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos básicos adicionales para el dashboard */
        .dashboard-section {
            padding: 20px;
            text-align: center;
        }
        .dashboard-section h2 {
            margin-bottom: 10px;
            font-size: 2em;
        }
        .dashboard-section p {
            font-size: 1.1em;
            color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=dashboard" class="active">Dashboard</a></li>
                <li><a href="index.php?page=profile">Perfil</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard-section">
            <h2>Bienvenido, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p>Este es tu panel de control. Aquí podrás gestionar tus datos, ver notificaciones y acceder a las funcionalidades de la aplicación.</p>
            <!-- Agrega más contenido o widgets según sea necesario -->
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>