<?php
// public/delete_reservation.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}

if (!isset($_GET['id'])) {
    die("No se proporcionó el ID de la reserva.");
}

$id = intval($_GET['id']);
$db = Database::getInstance()->getConnection();

$stmt = $db->prepare("DELETE FROM reservations WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: index.php?page=restaurants");
exit;
?>