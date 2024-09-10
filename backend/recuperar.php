<?php

include 'conexion.php';
include 'enviar_correo.php'; // Incluimos el archivo que maneja el envío de correos

if (isset($_POST['correo'])) {
    $correo = $_POST['correo'];
    
    // Verificar si el correo existe
    $stmt = $conn->prepare("SELECT id, correo FROM empresas WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generar un token de recuperación de contraseña
        $reset_token = bin2hex(random_bytes(16)); // Generar un token de 32 caracteres
        $stmt = $conn->prepare("UPDATE empresas SET reset_token = ? WHERE correo = ?");
        $stmt->bind_param("ss", $reset_token, $correo);
        
        if ($stmt->execute()) {
            // Enlace para la recuperación de contraseña
            $reset_link = "https://tu-dominio.com/reset_password.php?token=" . $reset_token;

            // Usamos PHPMailer para enviar el correo
            if (enviarCorreoRecuperacion($correo, $reset_link)) {
                echo json_encode(["status" => "success", "message" => "Se ha enviado un correo con las instrucciones para recuperar su contraseña."]);
            } else {
                echo json_encode(["status" => "error", "message" => "No se pudo enviar el correo."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo generar el token de recuperación."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El correo no está registrado."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No se recibió ningún correo."]);
}

$conn->close();

?>
