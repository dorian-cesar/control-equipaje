<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


session_start();
include 'conexion.php';  // Incluye tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    // Verifica si el usuario existe en la base de datos
    $query = $conn->prepare("SELECT id, correo, password, sesiones_abiertas FROM empresas WHERE correo = ?");
    $query->bind_param('s', $correo);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verificar si la contraseña es correcta
        if (password_verify($password, $user['password'])) {
            // Verificar si el usuario ya ha alcanzado el límite de sesiones abiertas
            $max_sesiones = 2;
            if ($user['sesiones_abiertas'] >= $max_sesiones) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Has alcanzado el límite de sesiones abiertas. Cierra una sesión antes de continuar.'
                ]);
            } else {
                // Incrementar el contador de sesiones abiertas en la base de datos
                $new_sesiones_abiertas = $user['sesiones_abiertas'] + 1;
                $update_query = $conn->prepare("UPDATE empresas SET sesiones_abiertas = ? WHERE id = ?");
                $update_query->bind_param('ii', $new_sesiones_abiertas, $user['id']);
                $update_query->execute();

                // Iniciar sesión en el servidor
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['correo'] = $user['correo'];

                // Respuesta exitosa
                echo json_encode([
                    'status' => 'success',
                    'correo' => $user['correo']
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Contraseña incorrecta.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'El usuario no existe.'
        ]);
    }
}
