<?php
// logout.php

session_start();

if (isset($_SESSION['user_id'])) {
    include 'conexion.php';

    // Reducir la cantidad de sesiones activas
    $stmt = $conn->prepare("UPDATE empresas SET sesiones_abiertas = sesiones_abiertas - 1 WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();

    // Destruir la sesión
    session_unset();
    session_destroy();

    echo json_encode(['status' => 'success', 'message' => 'Sesión cerrada correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se ha iniciado sesión.']);
}
?>
