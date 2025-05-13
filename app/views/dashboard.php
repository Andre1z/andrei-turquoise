<?php
// app/views/dashboard.php

// Verifica si el usuario ha iniciado sesión; de lo contrario, redirige al login.
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Estilos básicos para estructurar el dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }
        header {
            background: #333;
            color: #fff;
            padding: 1em;
        }
        header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            margin-top: 0.5em;
        }
        nav li {
            margin-right: 1em;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        main {
            padding: 2em;
            max-width: 1000px;
            margin: auto;
            background: #fff;
        }
        .welcome {
            margin-bottom: 2em;
        }
        .stats, .content {
            margin-top: 2em;
        }
        footer {
            text-align: center;
            padding: 1em;
            background: #333;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <nav>
            <ul>
                <li><a href="/restaurants">Restaurantes</a></li>
                <li><a href="/orders">Pedidos</a></li>
                <li><a href="/logout">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="welcome">
            <h2>Bienvenido, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <p>Esta es tu área de administración. Desde aquí puedes gestionar tus restaurantes, pedidos y revisar estadísticas.</p>
        </section>
        <section class="stats">
            <h3>Estadísticas</h3>
            <p>Aquí podrás ver datos relevantes sobre la actividad de tu restaurante:</p>
            <ul>
                <li>Ventas diarias</li>
                <li>Número de pedidos</li>
                <li>Restaurantes activos</li>
            </ul>
        </section>
        <section class="content">
            <h3>Acciones Rápidas</h3>
            <p>Usa los enlaces del menú para administrar el sistema o consulta informes detallados de actividad.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>