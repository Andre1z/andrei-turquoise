<?php
// app/core/Request.php

/**
 * Clase Request para encapsular la información de la solicitud HTTP.
 * Esta clase ofrece métodos para obtener el método HTTP, la URI,
 * los parámetros de consulta, el cuerpo de la solicitud y los encabezados.
 */
class Request {

    /**
     * Método HTTP de la solicitud (GET, POST, etc.).
     *
     * @var string
     */
    protected $method;

    /**
     * Parte de la URI sin parámetros de consulta.
     *
     * @var string
     */
    protected $uri;

    /**
     * Parámetros de consulta (GET) en forma de arreglo asociativo.
     *
     * @var array
     */
    protected $queryParams;

    /**
     * Cuerpo de la solicitud; si se envía JSON se decodifica a arreglo asociativo.
     *
     * @var mixed
     */
    protected $body;

    /**
     * Encabezados de la solicitud.
     *
     * @var array
     */
    protected $headers;

    /**
     * Constructor que inicializa la solicitud.
     */
    public function __construct() {
        // Determinar el método HTTP
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // Obtener la URI (sin query string)
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Obtener parámetros de consulta
        $this->queryParams = $_GET;

        // Obtener los encabezados de la solicitud
        $this->headers = $this->getAllHeaders();

        // Leer el cuerpo de la solicitud (útil para POST, PUT, etc.)
        $input = file_get_contents('php://input');
        $this->body = $this->parseBody($input);
    }

    /**
     * Devuelve el método HTTP de la solicitud.
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Devuelve la URI solicitada sin parámetros de consulta.
     *
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Devuelve los parámetros de consulta (GET) como arreglo asociativo.
     *
     * @return array
     */
    public function getQueryParams() {
        return $this->queryParams;
    }

    /**
     * Devuelve el cuerpo de la solicitud.
     * Si se envió JSON y la cabecera "Content-Type" es "application/json",
     * se retorna el cuerpo decodificado a un arreglo asociativo.
     *
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Devuelve los encabezados de la solicitud en un arreglo asociativo.
     *
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * Recupera todos los encabezados de la solicitud.
     * Implementa una solución en caso de que la función nativa getallheaders() no esté disponible.
     *
     * @return array
     */
    protected function getAllHeaders() {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) === 'HTTP_') {
                // Convertir el nombre del header a un formato legible
                $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }

    /**
     * Procesa el cuerpo de la solicitud.
     * Si el Content-Type es "application/json", intenta decodificar el cuerpo a arreglo asociativo.
     * De lo contrario, retorna el cuerpo tal cual se recibió.
     *
     * @param string $input Entrada cruda del cuerpo de la solicitud.
     * @return mixed
     */
    protected function parseBody($input) {
        if (isset($this->headers['Content-Type']) && strpos($this->headers['Content-Type'], 'application/json') !== false) {
            $data = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        }
        return $input;
    }
}