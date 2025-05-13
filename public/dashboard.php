<?php
// public/dashboard.php

require_once __DIR__ . '/../config/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

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
                <li><a href="index.php?page=restaurants">Restaurantes</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="dashboard-section">
            <h2>Bienvenido, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p>Este es tu panel de control. Aquí podrás gestionar tus datos y acceder a las funcionalidades de la aplicación.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>