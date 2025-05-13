<?php
// app/controllers/RestaurantController.php

// Incluir el modelo para interactuar con la base de datos
require_once ROOT_PATH . '/app/models/Restaurant.php';

class RestaurantController {

    /**
     * Lista todos los restaurantes existentes.
     * Obtiene los datos a través del modelo y carga la vista correspondiente.
     */
    public function listAll() {
        // Se obtiene un array de restaurantes (se asume que el método getAll() está implementado)
        $restaurants = Restaurant::getAll();

        // Cargar la vista que mostrará la lista de restaurantes
        require ROOT_PATH . '/app/views/restaurants_list.php';
    }

    /**
     * Muestra los detalles de un restaurante específico.
     *
     * @param int $restaurantId Identificador del restaurante a visualizar.
     */
    public function view($restaurantId) {
        // Se busca el restaurante por su ID
        $restaurant = Restaurant::findById($restaurantId);

        if ($restaurant) {
            // Cargar la vista que muestra los detalles del restaurante
            require ROOT_PATH . '/app/views/restaurant_detail.php';
        } else {
            echo "Restaurante no encontrado.";
        }
    }

    /**
     * Procesa la creación de un nuevo restaurante.
     *
     * Si la solicitud es GET, muestra el formulario de creación (vista 'restaurant_create.php').
     * Si la solicitud es POST, recoge y valida los datos enviados desde el formulario,
     * y crea el restaurante a través del modelo.
     */
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger y sanitizar los datos enviados desde el formulario
            $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
            $address = isset($_POST['address']) ? trim($_POST['address']) : '';
            $phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';

            // Validar que se hayan completado todos los campos obligatorios
            if (empty($name) || empty($address) || empty($phone)) {
                echo "Todos los campos (Nombre, Dirección y Teléfono) son obligatorios.";
                return;
            }

            // Preparar los datos para insertar
            $restaurantData = [
                'name'       => $name,
                'address'    => $address,
                'phone'      => $phone,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Crear el restaurante mediante el modelo (se asume que Restaurant::create() devuelve el restaurante creado o false en caso de error)
            $restaurant = Restaurant::create($restaurantData);

            if ($restaurant) {
                // Redirigir a la lista de restaurantes en caso de éxito
                header("Location: /restaurants");
                exit;
            } else {
                echo "Ocurrió un error al crear el restaurante.";
            }
        } else {
            // Si la solicitud es GET, mostrar el formulario de creación
            require ROOT_PATH . '/app/views/restaurant_create.php';
        }
    }
}