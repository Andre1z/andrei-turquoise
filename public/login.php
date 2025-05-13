<?php
// public/login.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

session_start();

// Si ya existe un usuario en sesión, redirige al dashboard
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar los datos del formulario
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Por favor, complete todos los campos.';
    } else {
        // Obtener la conexión a la base de datos
        $db = Database::getInstance()->getConnection();

        // Preparamos la consulta para obtener el usuario según el email ingresado
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Verificamos la contraseña (usando password_verify, considerando que en registro se hashea)
            if (password_verify($password, $user->password)) {
                // Inicio de sesión correcto: se guarda la información mínima del usuario en la sesión
                $_SESSION['user'] = [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ];
                header("Location: index.php?page=dashboard");
                exit;
            } else {
                $error = 'Contraseña incorrecta.';
            }
        } else {
            $error = 'Usuario no encontrado.';
        }
    }
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
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
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