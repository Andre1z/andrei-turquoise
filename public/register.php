<?php
// public/register.php

// Inicia la sesión si aún no se ha iniciado
session_start();

// Si el usuario ya está autenticado, redirige a una página (por ejemplo, dashboard)
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header>
        <h1><?php echo APP_NAME; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php?page=home">Inicio</a></li>
                <li><a href="index.php?page=login">Iniciar Sesión</a></li>
                <li><a href="index.php?page=register" class="active">Registrarse</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="register-section">
            <h2>Registrarse</h2>
            <!-- El formulario enviará la información al mismo index.php mediante el parámetro "page=register" -->
            <form method="post" action="index.php?page=register">
                <div class="form-group">
                    <label for="name">Nombre Completo:</label>
                    <input type="text" name="name" id="name" placeholder="Tu nombre completo" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" id="email" placeholder="tucorreo@ejemplo.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Registrarse">
                </div>
            </form>
            <p>¿Ya tienes una cuenta? <a href="index.php?page=login">Inicia Sesión</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
    </footer>
</body>
</html>