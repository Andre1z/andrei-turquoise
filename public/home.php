<?php
// public/home.php
// Nota: Es asumido que core/index.php (o public/index.php) ya ha cargado la configuración (config/config.php)
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Home - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bienvenido a <?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="?page=home" class="active">Inicio</a></li>
                <li><a href="?page=login">Iniciar Sesión</a></li>
                <li><a href="?page=register">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h2>¡Bienvenido a nuestra aplicación!</h2>
            <p>Aquí podrás gestionar todos los aspectos relacionados con tu restaurante de forma sencilla y rápida.</p>
            <p>Utiliza el menú de navegación para acceder a las demás secciones de la aplicación.</p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>