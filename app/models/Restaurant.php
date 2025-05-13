<?php
// app/models/Restaurant.php

require_once ROOT_PATH . '/app/core/Database.php';

class Restaurant {

    public $id;
    public $name;
    public $address;
    public $phone;
    public $created_at;

    /**
     * Constructor.
     *
     * Permite inicializar el objeto Restaurant a partir de un arreglo asociativo.
     *
     * @param array $data Datos del restaurante.
     */
    public function __construct($data = []) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['address'])) {
            $this->address = $data['address'];
        }
        if (isset($data['phone'])) {
            $this->phone = $data['phone'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
    }

    /**
     * Obtiene todos los restaurantes.
     *
     * @return array Arreglo de objetos Restaurant.
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM restaurants");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $restaurants = [];
        foreach ($results as $row) {
            $restaurants[] = new Restaurant($row);
        }
        return $restaurants;
    }

    /**
     * Encuentra un restaurante por su ID.
     *
     * @param int $id Identificador único del restaurante.
     * @return Restaurant|null Retorna el objeto Restaurant encontrado o null si no se encuentra.
     */
    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM restaurants WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row) ? new Restaurant($row) : null;
    }

    /**
     * Crea un nuevo restaurante.
     *
     * Se espera un arreglo asociativo con las siguientes claves:
     * - name
     * - address
     * - phone
     *
     * @param array $data Datos para crear el restaurante.
     * @return Restaurant|false Retorna el objeto Restaurant creado o false en caso de error.
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO restaurants (name, address, phone, created_at)
                VALUES (:name, :address, :phone, :created_at)";
        $stmt = $db->prepare($sql);

        $params = [
            ':name'       => $data['name'],
            ':address'    => $data['address'],
            ':phone'      => $data['phone'],
            ':created_at' => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($params)) {
            $data['id'] = $db->lastInsertId();
            $data['created_at'] = $params[':created_at'];
            return new Restaurant($data);
        }
        return false;
    }

    /**
     * Actualiza un restaurante existente.
     *
     * @param int   $id   Identificador del restaurante a actualizar.
     * @param array $data Datos actualizados (se esperan claves: name, address, phone).
     * @return bool Retorna true en caso de éxito o false si falla.
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE restaurants 
                SET name = :name, address = :address, phone = :phone
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $params = [
            ':name'    => $data['name'],
            ':address' => $data['address'],
            ':phone'   => $data['phone'],
            ':id'      => $id
        ];
        return $stmt->execute($params);
    }

    /**
     * Elimina un restaurante.
     *
     * @param int $id Identificador del restaurante a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa o false en caso contrario.
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM restaurants WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}