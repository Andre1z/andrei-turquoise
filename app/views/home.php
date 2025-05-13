<?php
// app/views/home.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo APP_NAME; ?> - Bienvenido</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Estilos básicos para la página de inicio */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }
        header {
            background: #333;
            color: #fff;
            padding: 1em;
            text-align: center;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        nav li {
            margin: 0 1em;
        }
        nav a {
            color: #fff;
            text-decoration: none;
        }
        main {
            max-width: 960px;
            margin: 2em auto;
            padding: 1em;
            background: #fff;
        }
        .hero {
            text-align: center;
            margin: 2em 0;
        }
        .features, .about {
            margin: 2em 0;
        }
        footer {
            text-align: center;
            padding: 1em;
            background: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="/">Inicio</a></li>
                <li><a href="/login">Iniciar Sesión</a></li>
                <li><a href="/register">Registro</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h2>Bienvenido a <?php echo APP_NAME; ?></h2>
            <p>Gestiona restaurantes, pedidos y mejora la administración de tu negocio de forma sencilla y eficaz.</p>
        </section>
        <section class="features">
            <h3>Nuestras Funcionalidades</h3>
            <ul>
                <li>Administración completa de restaurantes y menús.</li>
                <li>Gestión de pedidos y reservas en línea.</li>
                <li>Panel de control intuitivo y fácil de usar.</li>
            </ul>
        </section>
        <section class="about">
            <h3>Acerca de Nosotros</h3>
            <p>Somos una solución integral para gestionar restaurantes, diseñada para optimizar la experiencia de administración y la satisfacción de tus clientes.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>