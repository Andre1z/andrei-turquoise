<?php
// public/register.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

session_start();

// Si el usuario ya está autenticado, redirige al dashboard
if (isset($_SESSION['user'])) {
    header("Location: index.php?page=dashboard");
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar los datos del formulario
    $name             = trim($_POST['name'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        $db = Database::getInstance()->getConnection();

        // Verificar que no exista ya un usuario con ese correo
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $error = 'Ya existe un usuario registrado con este correo electrónico.';
        } else {
            // Hashear la contraseña usando el algoritmo default de PHP
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $inserted = $stmt->execute([
                ':name'     => $name,
                ':email'    => $email,
                ':password' => $passwordHash
            ]);

            if ($inserted) {
                // Opcional: Obtener el ID del usuario recién insertado
                $userId = $db->lastInsertId();

                // Iniciamos la sesión para el nuevo usuario
                $_SESSION['user'] = [
                    'id'    => $userId,
                    'name'  => $name,
                    'email' => $email
                ];

                $success = 'Registro exitoso. Redirigiendo al dashboard...';
                header("Refresh:2; url=index.php?page=dashboard");
            } else {
                $error = 'Error al registrar el usuario. Inténtalo de nuevo.';
            }
        }
    }
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
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
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