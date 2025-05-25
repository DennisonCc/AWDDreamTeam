<?php
session_start();
require_once 'connection.php';

header('Content-Type: application/json');

// Verificar sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $sql = "SELECT icono, mensaje, fecha FROM notificaciones WHERE user_id = :user_id ORDER BY fecha DESC LIMIT 30";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notificaciones);
} catch (PDOException $e) {
    error_log("Error al obtener notificaciones: " . $e->getMessage());
    echo json_encode([]);
}
?>
