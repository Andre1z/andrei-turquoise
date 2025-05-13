<?php
// config/config.php

// Mostrar errores para desarrollo (deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración general de la aplicación
define('APP_NAME', 'Gestión de Restaurantes');
define('APP_URL', 'http://localhost/gestion_restaurantes_simple');
date_default_timezone_set('Europe/Madrid');

// Configuración de la base de datos utilizando SQLite
define('DB_DRIVER', 'sqlite');
// Se espera que el archivo se encuentre en la carpeta "database/migrations" (o en este caso, puedes usar otra ubicación simple)
define('DB_PATH', realpath(__DIR__ . '/../database/database.sqlite'));
?>