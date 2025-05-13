<?php
// public/index.php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

// Aquí puedes implementar un enrutador sencillo. Por ejemplo, un switch basado en un parámetro "page".
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        include 'home.php';
        break;
    case 'login':
        include 'login.php';
        break;
    case 'register':
        include 'register.php';
        break;
    // Agrega más casos según necesites.
    default:
        echo "Página no encontrada.";
        break;
}
?>