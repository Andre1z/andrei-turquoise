<?php
// app/controllers/OrderController.php

// Incluir el modelo Order para poder interactuar con la base de datos
require_once ROOT_PATH . '/app/models/Order.php';

class OrderController {

    /**
     * Lista todas las órdenes existentes.
     *
     * Se asume que Order::getAll() devuelve un array con los objetos/elementos de cada orden.
     * La vista 'orders_list.php' será la encargada de mostrar estas órdenes.
     */
    public function listAll() {
        $orders = Order::getAll();

        // Se carga la vista pasando la variable $orders
        require ROOT_PATH . '/app/views/orders_list.php';
    }

    /**
     * Procesa la creación de una nueva orden.
     *
     * - Si la solicitud es GET, muestra el formulario (vista 'order_create.php').
     * - Si la solicitud es POST, recoge los datos del formulario, los valida y crea la orden.
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y sanitizar los datos enviados desde el formulario
            $restaurantId = isset($_POST['restaurant_id']) ? (int) $_POST['restaurant_id'] : null;
            $userId       = isset($_POST['user_id']) ? (int) $_POST['user_id'] : null;
            $items        = isset($_POST['items']) ? trim($_POST['items']) : '';
            $total        = isset($_POST['total']) ? (float) $_POST['total'] : null;

            // Validar que se hayan enviado todos los campos obligatorios
            if (!$restaurantId || !$userId || empty($items) || $total === null) {
                echo "Todos los campos son requeridos para crear una orden.";
                return;
            }

            // Preparar los datos de la orden
            $orderData = [
                'restaurant_id' => $restaurantId,
                'user_id'       => $userId,
                'items'         => $items,
                'total'         => $total,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            // Crear la orden usando el modelo Order
            $order = Order::create($orderData);

            if ($order) {
                // Redirigir a la lista de órdenes en caso de éxito
                header("Location: /orders");
                exit;
            } else {
                echo "Ocurrió un error al crear la orden.";
            }
        } else {
            // Si la solicitud es GET, mostrar el formulario de creación de la orden
            require ROOT_PATH . '/app/views/order_create.php';
        }
    }

    /**
     * Muestra los detalles de una orden específica.
     *
     * @param int $orderId Identificador de la orden a mostrar.
     */
    public function view($orderId) {
        $order = Order::findById($orderId);
        if ($order) {
            // Mostrar la vista de detalles para el orden encontrado
            require ROOT_PATH . '/app/views/order_detail.php';
        } else {
            echo "Orden no encontrada.";
        }
    }
}