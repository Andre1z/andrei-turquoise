<?php
// public/login.php

// Inicia la sesión, en caso de que no se haya iniciado ya
session_start();

// Si ya existe un usuario en sesión, redirige a una página de "dashboard" o inicio
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=home">Inicio</a></li>
                <li><a href="index.php?page=login" class="active">Iniciar Sesión</a></li>
                <li><a href="index.php?page=register">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login-section">
            <h2>Iniciar Sesión</h2>
            <!-- El formulario enviará la información al mismo index.php, en el que tu enrutador decidirá cómo procesarla -->
            <form method="post" action="index.php?page=login">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" id="email" placeholder="tucorreo@ejemplo.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Entrar">
                </div>
            </form>
            <p>¿No tienes una cuenta? <a href="index.php?page=register">Regístrate aquí</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>