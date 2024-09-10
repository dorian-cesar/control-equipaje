<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'vendor/autoload.php';

require '../vendor/autoload.php';

function enviarCorreoRecuperacion($correoDestino, $enlaceRecuperacion) {
    $mail = new PHPMailer(true);

    try {
        // Configuraciones del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.tu-servidor.com'; // Cambia a tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu-email@dominio.com'; // Cambia a tu email
        $mail->Password = 'tu-contraseña'; // Cambia a tu contraseña
        $mail->SMTPSecure = 'tls'; // TLS o SSL
        $mail->Port = 587; // Puerto SMTP para TLS (o 465 para SSL)

        // Remitente y destinatarios
        $mail->setFrom('no-reply@tu-dominio.com', 'Recuperación de Contraseña');
        $mail->addAddress($correoDestino); // Destinatario

        // Contenido del correo
        $mail->isHTML(true); 
        $mail->Subject = 'Recuperación de Contraseña';
        $mail->Body = "Haga clic en el siguiente enlace para recuperar su contraseña: <a href='$enlaceRecuperacion'>$enlaceRecuperacion</a>";

        // Enviar correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        // En caso de error
        return false;
    }
}
?>
