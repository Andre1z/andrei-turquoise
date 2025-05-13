<?php
// public/logout.php

// Iniciamos la sesión (o la retomamos) para poder manipularla
session_start();

// Limpiar todas las variables de sesión
$_SESSION = [];

// Si se utiliza cookies para la sesión, eliminar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Redirigir al usuario, por ejemplo, a la página principal (home)
// Puedes cambiar "home" por otra ruta si lo deseas.
header("Location: index.php?page=home");
exit;