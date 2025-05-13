<?php
// app/views/login.php

// Iniciar sesión si aún no se ha hecho
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario ya está logueado, redirige al dashboard
if (isset($_SESSION['user'])) {
    header("Location: /dashboard");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Estilos básicos para la página de inicio de sesión */
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 1em;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container label {
            margin-bottom: 0.5em;
            font-weight: bold;
        }
        .login-container input[type="email"],
        .login-container input[type="password"] {
            padding: 0.75em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container input[type="submit"] {
            padding: 0.75em;
            border: none;
            background: #333;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container .links {
            text-align: center;
            margin-top: 1em;
        }
        .login-container .links a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="/login" method="post">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
            
            <input type="submit" value="Entrar">
        </form>
        <div class="links">
            <p>¿No tienes una cuenta? <a href="/register">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>