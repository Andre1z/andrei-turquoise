<?php
// app/core/Response.php

/**
 * Clase Response
 *
 * Esta clase encapsula la lógica para enviar respuestas HTTP.
 * Permite configurar el código de estado, agregar encabezados y enviar el contenido
 * de la respuesta, ya sea como texto plano o en formato JSON.
 */
class Response {

    /**
     * Código de estado HTTP (por defecto 200 OK).
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Arreglo de encabezados HTTP a enviar.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Establece el código de estado de la respuesta.
     *
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Agrega o sobrescribe un encabezado en la respuesta.
     *
     * @param string $name  Nombre del encabezado.
     * @param string $value Valor del encabezado.
     * @return $this
     */
    public function setHeader($name, $value) {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Envía todos los encabezados HTTP configurados al cliente.
     */
    protected function sendHeaders() {
        // Establecer el código de estado HTTP
        http_response_code($this->statusCode);

        // Enviar cada encabezado definido
        foreach ($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    /**
     * Envía la respuesta al cliente.
     *
     * Se envían primero los encabezados y luego el cuerpo de la respuesta.
     *
     * @param string $body Contenido de la respuesta.
     */
    public function send($body = '') {
        $this->sendHeaders();
        echo $body;
        exit;
    }

    /**
     * Envía una respuesta en formato JSON.
     *
     * Este método configura el encabezado "Content-Type" como "application/json",
     * codifica los datos proporcionados y luego envía la respuesta.
     *
     * @param mixed $data Los datos a enviar en formato JSON.
     */
    public function json($data) {
        $this->setHeader('Content-Type', 'application/json');
        $jsonData = json_encode($data);
        $this->send($jsonData);
    }
}