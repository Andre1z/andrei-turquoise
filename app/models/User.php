<?php
// app/models/User.php

require_once ROOT_PATH . '/app/core/Database.php';

class User {

    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    /**
     * Constructor.
     *
     * Permite inicializar el objeto User a partir de un arreglo asociativo.
     *
     * @param array $data Datos del usuario.
     */
    public function __construct($data = []) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['name'])) {
            $this->name = $data['name'];
        }
        if (isset($data['email'])) {
            $this->email = $data['email'];
        }
        if (isset($data['password'])) {
            $this->password = $data['password'];
        }
        if (isset($data['created_at'])) {
            $this->created_at = $data['created_at'];
        }
    }

    /**
     * Encuentra un usuario por su email.
     *
     * @param string $email Email a buscar.
     * @return User|null Retorna el objeto User encontrado o null si no existe.
     */
    public static function findByEmail($email) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row) ? new User($row) : null;
    }

    /**
     * Crea un nuevo usuario.
     *
     * Se espera un arreglo asociativo con las siguientes claves:
     * - name
     * - email
     * - password (se asume que la contraseña ya está hasheada, o se puede hashear aquí)
     *
     * @param array $data Datos para crear el usuario.
     * @return User|false Retorna el objeto User creado o false en caso de error.
     */
    public static function create($data) {
        $db = Database::getInstance()->getConnection();
        $sql = "INSERT INTO users (name, email, password, created_at)
                VALUES (:name, :email, :password, :created_at)";
        $stmt = $db->prepare($sql);

        $params = [
            ':name'       => $data['name'],
            ':email'      => $data['email'],
            ':password'   => $data['password'],
            ':created_at' => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($params)) {
            $data['id'] = $db->lastInsertId();
            $data['created_at'] = $params[':created_at'];
            return new User($data);
        }
        return false;
    }

    /**
     * Obtiene todos los usuarios.
     *
     * @return array Arreglo de objetos User.
     */
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM users");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $row) {
            $users[] = new User($row);
        }
        return $users;
    }

    /**
     * Actualiza un usuario existente.
     *
     * @param int   $id   Identificador del usuario a actualizar.
     * @param array $data Datos actualizados (pueden incluir name, email, password).
     * @return bool Retorna true en caso de éxito o false si falla.
     */
    public static function update($id, $data) {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE users SET name = :name, email = :email, password = :password
                WHERE id = :id";
        $stmt = $db->prepare($sql);
        $params = [
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => isset($data['password']) ? $data['password'] : '',
            ':id'       => $id
        ];
        return $stmt->execute($params);
    }

    /**
     * Elimina un usuario.
     *
     * @param int $id Identificador del usuario a eliminar.
     * @return bool Retorna true si la eliminación fue exitosa o false en caso contrario.
     */
    public static function delete($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}