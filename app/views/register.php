<?php
// app/views/register.php

// Iniciar la sesión si aún no se ha iniciado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario ya está autenticado, redirigir al dashboard
if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Estilos básicos para la página de registro */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }
        .register-container {
            background: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
        }
        .register-container h2 {
            text-align: center;
            margin-bottom: 1em;
        }
        .register-container form {
            display: flex;
            flex-direction: column;
        }
        .register-container label {
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            padding: 0.75em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-container input[type="submit"] {
            padding: 0.75em;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .register-container .links {
            text-align: center;
            margin-top: 1em;
        }
        .register-container .links a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registro</h2>
        <form action="/register" method="post">
            <label for="name">Nombre Completo:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <input type="submit" value="Registrarse">
        </form>
        <div class="links">
            <p>¿Ya tienes una cuenta? <a href="/login">Inicia Sesión</a></p>
        </div>
    </div>
</body>
</html>