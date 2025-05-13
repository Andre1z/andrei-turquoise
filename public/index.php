<?php
// public/index.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

// Inicia la sesión si aún no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    case 'restaurants':
        include __DIR__ . '/restaurants.php';
        break;
    case 'edit_restaurant':
        include __DIR__ . '/edit_restaurant.php';
        break;
    case 'delete_restaurant':
        include __DIR__ . '/delete_restaurant.php';
        break;
    case 'edit_reservation':
        include __DIR__ . '/edit_reservation.php';
        break;
    case 'delete_reservation':
        include __DIR__ . '/delete_reservation.php';
        break;
    case 'logout':
        include __DIR__ . '/logout.php';
        break;
    default:
        echo "Página no encontrada.";
        break;
}
?>