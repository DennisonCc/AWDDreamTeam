<?php

session_start();
require_once 'connection.php';

header('Content-Type: application/json');


if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT icono, mensaje, fecha FROM notificaciones WHERE user_id = ? ORDER BY fecha DESC LIMIT 30";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notificaciones = [];
while ($row = $result->fetch_assoc()) {
    $notificaciones[] = $row;
}

echo json_encode($notificaciones);
