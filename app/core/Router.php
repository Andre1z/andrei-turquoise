<?php
// app/core/Router.php

/**
 * Clase Router
 *
 * Esta clase se encarga de registrar rutas y despachar la solicitud HTTP
 * al callback correspondiente según el método y la URI. El enrutador permite
 * registrar rutas para métodos GET y POST, y ofrece un callback por defecto
 * en caso de que la ruta no sea encontrada.
 */
class Router {

    /**
     * Array con la definición de las rutas.
     *
     * Cada entrada es un arreglo con las claves: method, route y callback.
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Callback para manejar rutas no encontradas (404).
     *
     * @var callable
     */
    protected $notFoundCallback;

    /**
     * Constructor de la clase.
     *
     * Se define un callback por defecto para rutas no encontradas.
     */
    public function __construct() {
        $this->notFoundCallback = function() {
            http_response_code(404);
            echo "404 - Recurso no encontrado";
        };
    }

    /**
     * Registra una ruta para el método GET.
     *
     * @param string   $route    Ruta a registrar.
     * @param callable $callback Función a ejecutar si la ruta coincide.
     */
    public function get($route, $callback) {
        $this->addRoute('GET', $route, $callback);
    }

    /**
     * Registra una ruta para el método POST.
     *
     * @param string   $route    Ruta a registrar.
     * @param callable $callback Función a ejecutar si la ruta coincide.
     */
    public function post($route, $callback) {
        $this->addRoute('POST', $route, $callback);
    }

    /**
     * Función genérica para agregar una nueva ruta.
     *
     * @param string   $method   Método HTTP (GET, POST, etc.).
     * @param string   $route    Ruta a registrar.
     * @param callable $callback Función a ejecutar.
     */
    public function addRoute($method, $route, $callback) {
        $route = $this->normalizeRoute($route);
        $this->routes[] = [
            'method'   => strtoupper($method),
            'route'    => $route,
            'callback' => $callback
        ];
    }

    /**
     * Despacha la solicitud HTTP.
     *
     * Compara la URI solicitada y el método HTTP con las rutas registradas.
     * Si encuentra una coincidencia, ejecuta su callback. Si no, invoca
     * el callback de ruta no encontrada.
     *
     * @param string $uri           URI solicitada.
     * @param string $requestMethod Método HTTP de la solicitud.
     */
    public function dispatch($uri, $requestMethod) {
        $uri = $this->normalizeRoute($uri);
        $requestMethod = strtoupper($requestMethod);

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['route'] === $uri) {
                // Se ejecuta el callback asociado a la ruta
                call_user_func($route['callback']);
                return;
            }
        }
        // Si no se encontró una ruta coincidente, se invoca el callback de error 404.
        call_user_func($this->notFoundCallback);
    }

    /**
     * Normaliza la ruta eliminando barras diagonales finales.
     *
     * Esto ayuda a comparar de forma uniforme las rutas registradas con la URI solicitada.
     *
     * @param string $route Ruta a normalizar.
     * @return string Ruta normalizada.
     */
    protected function normalizeRoute($route) {
        $route = rtrim($route, '/');
        return ($route === '') ? '/' : $route;
    }

    /**
     * Permite definir un callback personalizado para rutas no encontradas.
     *
     * @param callable $callback Función que se ejecutará en caso de que no se encuentre la ruta.
     */
    public function setNotFoundCallback($callback) {
        $this->notFoundCallback = $callback;
    }
}