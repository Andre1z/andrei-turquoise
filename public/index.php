<?php
// public/index.php
// Controlador frontal: punto de entrada único para todas las solicitudes

// Mostrar errores para desarrollo (deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión
session_start();

// Definir la raíz del proyecto para facilitar rutas absolutas
define('ROOT_PATH', realpath(__DIR__ . '/../'));

// Cargar la configuración principal del proyecto
require_once ROOT_PATH . '/config/config.php';

// Implementar un autoloading básico para cargar clases automáticamente
spl_autoload_register(function ($className) {
    // Reemplazar posibles namespaces por separadores de directorio
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    
    // Definir las rutas donde buscar la clase
    $paths = [
        ROOT_PATH . '/app/core/' . $className . '.php',
        ROOT_PATH . '/app/controllers/' . $className . '.php',
        ROOT_PATH . '/app/models/' . $className . '.php'
    ];
    
    // Incluir el archivo de clase en cuanto se encuentre
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Cargar el enrutador básico (se asume que está en app/core/Router.php)
require_once ROOT_PATH . '/app/core/Router.php';

// Instanciar el enrutador
$router = new Router();

// Definir rutas y sus acciones (clausuras o callbacks):

// Ruta: Página de inicio
$router->get('/', function() {
    require ROOT_PATH . '/app/views/home.php';
});

// Ruta: Formulario de login
$router->get('/login', function() {
    require ROOT_PATH . '/app/views/login.php';
});

// Ruta: Procesa el login (envío del formulario)
$router->post('/login', function() {
    // Se asume que AuthController existe y está en app/controllers/
    $authController = new AuthController();
    $authController->login();
});

// Ruta: Cierre de sesión (logout)
$router->get('/logout', function() {
    $authController = new AuthController();
    $authController->logout();
});

// Ruta: Formulario de registro
$router->get('/register', function() {
    require ROOT_PATH . '/app/views/register.php';
});

// Ruta: Procesa el registro
$router->post('/register', function() {
    $authController = new AuthController();
    $authController->register();
});

// Ejemplo de ruta para listar restaurantes
$router->get('/restaurants', function() {
    $restaurantController = new RestaurantController();
    $restaurantController->listAll();
});

// Capturar la URI y el método HTTP de la solicitud
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Despachar la solicitud para que el enrutador ejecute la acción asociada
$router->dispatch($requestUri, $requestMethod);