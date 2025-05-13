<?php
// app/controllers/AuthController.php

// Asegúrate de que la constante ROOT_PATH esté definida en index.php, para poder incluir otros archivos
require_once ROOT_PATH . '/app/models/User.php';

class AuthController {

    /**
     * Procesa el login de un usuario.
     *
     * Se espera que se envíe un formulario vía POST con los campos:
     * - email
     * - password
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y limpiar los datos enviados por el formulario
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Validar campos obligatorios
            if (empty($email) || empty($password)) {
                echo "Email y contraseña son requeridos.";
                return;
            }

            // Buscar al usuario por email
            $user = User::findByEmail($email);

            if (!$user) {
                echo "Usuario no encontrado.";
                return;
            }

            // Comprobar que la contraseña coincide (se asume que está almacenada hasheada)
            if (!password_verify($password, $user->password)) {
                echo "Credenciales incorrectas.";
                return;
            }

            // Login exitoso, almacenar datos básicos del usuario en la sesión
            $_SESSION['user'] = [
                'id'    => $user->id,
                'email' => $user->email,
                'name'  => $user->name
            ];

            // Redirigir al área de usuario o dashboard
            header("Location: /dashboard");
            exit;
        }

        // Si no es un método POST respondemos con un error (normalmente este método solo se invoca vía formulario)
        echo "Método no permitido.";
    }

    /**
     * Procesa el registro de un nuevo usuario.
     *
     * Se espera un formulario vía POST con los campos:
     * - name
     * - email
     * - password
     * - confirm_password
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y limpiar los datos del formulario
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            // Validar que todos los campos estén completos
            if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
                echo "Todos los campos son requeridos.";
                return;
            }

            // Validar que ambas contraseñas coincidan
            if ($password !== $confirmPassword) {
                echo "Las contraseñas no coinciden.";
                return;
            }

            // Verificar si ya existe un usuario con el mismo email
            $existingUser = User::findByEmail($email);
            if ($existingUser) {
                echo "El usuario ya existe.";
                return;
            }

            // Hashear la contraseña antes de almacenarla
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Crear el usuario utilizando el modelo. Se asume que el método create devuelve el usuario creado o false en caso de error.
            $user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => $hashedPassword
            ]);

            if (!$user) {
                echo "Error al registrar el usuario.";
                return;
            }

            // Registro exitoso: redirigir al formulario de login o iniciar sesión automáticamente
            header("Location: /login");
            exit;
        }
        echo "Método no permitido.";
    }

    /**
     * Procesa el cierre de sesión (logout) del usuario.
     */
    public function logout() {
        // Eliminar todas las variables de sesión
        session_unset();
        session_destroy();

        // Redirigir al usuario a la página de inicio
        header("Location: /");
        exit;
    }
}