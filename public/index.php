<?php
// public/index.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

// Inicia la sesión si aún no está activa.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener el parámetro 'page' de la URL; por defecto se carga "home".
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        include __DIR__ . '/home.php';
        break;
    case 'login':
        include __DIR__ . '/login.php';
        break;
    case 'register':
        include __DIR__ . '/register.php';
        break;
    case 'dashboard':
        include __DIR__ . '/dashboard.php';
        break;
    case 'profile':
        include __DIR__ . '/profile.php';
        break;
    case 'logout':
        include __DIR__ . '/logout.php';
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>