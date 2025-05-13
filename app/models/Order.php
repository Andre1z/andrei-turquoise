<?php
// app/models/Order.php

require_once ROOT_PATH . '/app/core/Database.php';

class Order {

    public $id;
    public $restaurant_id;
    public $user_id;
    public $items;
    public $total;
    public $created_at;

    /**
     * Constructor.
     *
     * Permite inicializar el objeto Order a partir de un arreglo asociativo.
     *
     * @param array $data Datos de la orden.
     */
    public function __construct($data = []) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['restaurant_id'])) {
            $this->restaurant_id = $data['restaurant_id'];
        }
        if (isset($data['user_id'])) {
            $this->user_id = $data['user_id'];
        }
        if (isset($data['items'])) {
            $this->items = $data['items'];
        }
        if (isset($data['total'])) {
            $this->total = $data['total'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
    }

    /**
     * Obtiene todas las órdenes desde la tabla orders.
     *
     * @return array Arreglo de objetos Order.
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM orders");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];
        foreach ($results as $row) {
            $orders[] = new Order($row);
        }
        return $orders;
    }

    /**
     * Encuentra una orden por su ID.
     *
     * @param int $id Identificador único de la orden.
     * @return Order|null Retorna el objeto Order encontrado o null si no existe.
     */
    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM orders WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row) ? new Order($row) : null;
    }

    /**
     * Crea una nueva orden.
     *
     * Se espera un arreglo asociativo con las siguientes claves:
     *  - restaurant_id
     *  - user_id
     *  - items       (por ejemplo, en formato JSON o como texto)
     *  - total       (valor numérico total)
     *
     * @param array $data Datos para crear la orden.
     * @return Order|false Retorna el objeto Order creado o false en caso de error.
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO orders (restaurant_id, user_id, items, total, created_at)
                VALUES (:restaurant_id, :user_id, :items, :total, :created_at)";
        $stmt = $db->prepare($sql);

        $params = [
            ':restaurant_id' => $data['restaurant_id'],
            ':user_id'       => $data['user_id'],
            ':items'         => $data['items'],
            ':total'         => $data['total'],
            ':created_at'    => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($params)) {
            $data['id'] = $db->lastInsertId();
            $data['created_at'] = $params[':created_at'];
            return new Order($data);
        }
        return false;
    }

    /**
     * Actualiza una orden existente.
     *
     * @param int   $id   Identificador de la orden a actualizar.
     * @param array $data Datos actualizados. Se esperan claves: restaurant_id, user_id, items, total.
     * @return bool Retorna true en caso de éxito o false si falla.
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE orders 
                SET restaurant_id = :restaurant_id, user_id = :user_id, items = :items, total = :total
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $params = [
            ':restaurant_id' => $data['restaurant_id'],
            ':user_id'       => $data['user_id'],
            ':items'         => $data['items'],
            ':total'         => $data['total'],
            ':id'            => $id
        ];
        return $stmt->execute($params);
    }

    /**
     * Elimina una orden.
     *
     * @param int $id Identificador de la orden a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa o false en caso contrario.
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM orders WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}