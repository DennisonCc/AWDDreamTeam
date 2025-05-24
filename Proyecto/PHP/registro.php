<?php

include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);


    if ($password !== $confirm_password) {
        // Mostrar mensaje de error y detener ejecución
        echo '<script>alert("Las contraseñas no coinciden."); window.history.back();</script>';
        exit();
    } else {
        $sql = "SELECT id FROM usuarios WHERE username = :username OR email = :email LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<script>alert("El usuario o correo ya existe."); window.history.back();</script>';
            exit();
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
            if ($stmt->execute()) {
                header('Location: ../index.php?registro=exitoso');
                exit();
            } else {
                echo '<script>alert("Error al registrar. Intenta de nuevo."); window.history.back();</script>';
                exit();
            }
        }
    }
}
?>
