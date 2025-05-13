<?php
// config/config.php

/**
 * Configuración general del proyecto.
 * En este ejemplo se utiliza SQLite para la conexión a la base de datos, 
 * y el archivo de la base de datos se ubicará en la carpeta database/migrations.
 */

// Mostrar errores para entorno de desarrollo (deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración general de la aplicación
define('APP_NAME', 'Gestión de Restaurantes');
define('APP_URL', 'http://localhost/restaurant-management');
date_default_timezone_set('Europe/Madrid');

// Configuración de la base de datos usando SQLite
// Se define el driver y la ruta completa al archivo que funcionará como base de datos.
// Asegúrate de que la carpeta "database/migrations" tenga permisos de escritura.
define('DB_DRIVER', 'sqlite');
define('DB_PATH', realpath(__DIR__ . '/../database/migrations/database.sqlite'));