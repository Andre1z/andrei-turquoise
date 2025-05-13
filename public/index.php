<?php
// public/index.php

// Incluir la configuración y la clase de base de datos si son necesarios
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

// Iniciar la sesión para poder gestionar las variables de usuario
session_start();

// Determinar la página solicitada; por defecto se carga "home"
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
    case 'logout':
        include __DIR__ . '/logout.php';
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>