<?php
// app/models/Menu.php

require_once ROOT_PATH . '/app/core/Database.php';

class Menu {

    public $id;
    public $restaurant_id;
    public $name;
    public $description;
    public $created_at;

    /**
     * Constructor.
     *
     * Permite inicializar el objeto Menu a partir de un arreglo asociativo.
     *
     * @param array $data Datos del menú.
     */
    public function __construct($data = []) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['restaurant_id'])) {
            $this->restaurant_id = $data['restaurant_id'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['description'])) {
            $this->description = $data['description'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
    }

    /**
     * Obtiene todos los registros de la tabla menus.
     *
     * @return array Arreglo de objetos Menu.
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM menus");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $menus = [];
        foreach ($results as $row) {
            $menus[] = new Menu($row);
        }
        return $menus;
    }

    /**
     * Encuentra un menú por su ID.
     *
     * @param int $id Identificador único.
     * @return Menu|null Retorna el objeto Menu encontrado o null.
     */
    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM menus WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row) ? new Menu($row) : null;
    }

    /**
     * Encuentra todos los menús asociados a un restaurante específico.
     *
     * @param int $restaurant_id Identificador del restaurante.
     * @return array Arreglo de objetos Menu.
     */
    public static function findByRestaurantId($restaurant_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM menus WHERE restaurant_id = :restaurant_id");
        $stmt->execute([':restaurant_id' => $restaurant_id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $menus = [];
        foreach ($results as $row) {
            $menus[] = new Menu($row);
        }
        return $menus;
    }

    /**
     * Crea un nuevo registro en la tabla menus.
     *
     * Se espera un arreglo asociativo con las siguientes llaves:
     *  - restaurant_id
     *  - name
     *  - description (opcional)
     *
     * @param array $data Datos para crear el menú.
     * @return Menu|false Retorna el objeto Menu creado o false si ocurre un error.
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO menus (restaurant_id, name, description, created_at)
                VALUES (:restaurant_id, :name, :description, :created_at)";
        $stmt = $db->prepare($sql);

        $params = [
            ':restaurant_id' => $data['restaurant_id'],
            ':name'          => $data['name'],
            ':description'   => isset($data['description']) ? $data['description'] : '',
            ':created_at'    => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($params)) {
            $data['id'] = $db->lastInsertId();
            $data['created_at'] = $params[':created_at'];
            return new Menu($data);
        }
        return false;
    }

    /**
     * Actualiza un registro de menú.
     *
     * @param int   $id   Identificador del menú a actualizar.
     * @param array $data Datos actualizados (se esperan claves: restaurant_id, name, description).
     * @return bool Retorna true en caso de éxito o false si falla.
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE menus 
                SET restaurant_id = :restaurant_id, name = :name, description = :description
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $params = [
            ':restaurant_id' => $data['restaurant_id'],
            ':name'          => $data['name'],
            ':description'   => isset($data['description']) ? $data['description'] : '',
            ':id'            => $id
        ];
        return $stmt->execute($params);
    }

    /**
     * Elimina un registro de menú.
     *
     * @param int $id Identificador del menú a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa o false de lo contrario.
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM menus WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}