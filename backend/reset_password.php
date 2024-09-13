<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verificar que el token esté en la URL
    if (isset($_GET['token'])) {
        $token = $_GET['token'];

        // Buscar el token en la base de datos
        $stmt = $conn->prepare("SELECT * FROM empresas WHERE reset_token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Token encontrado, mostrar formulario para nueva contraseña
            echo '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Restablecer Contraseña</title>
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
            </head>
            <body class="bg-light">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">Restablecer Contraseña</h3>
                                    <form action="reset_password.php" method="POST">
                                        <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
                                        <div class="form-group">
                                            <label for="new_password">Nueva Contraseña</label>
                                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Ingrese nueva contraseña" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Confirmar Contraseña</label>
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirme la nueva contraseña" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>';
        } else {
            echo "Token inválido o expirado.";
        }
    } else {
        echo "Token no proporcionado.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el restablecimiento de la contraseña
    if (isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password'])) {
        $token = $_POST['token'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Validar la longitud de la nueva contraseña (opcional)
            if (strlen($new_password) < 8) {
                echo "La contraseña debe tener al menos 8 caracteres.";
                exit();
            }

            // Buscar el token en la base de datos
            $stmt = $conn->prepare("SELECT * FROM empresas WHERE reset_token = ?");
            $stmt->bind_param('s', $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Actualizar la contraseña en la base de datos
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE empresas SET password = ?, reset_token = NULL WHERE reset_token = ?");
                $stmt->bind_param('ss', $hashed_password, $token);
                
                if ($stmt->execute()) {
                    echo "Contraseña actualizada correctamente.";
                } else {
                    echo "Error al actualizar la contraseña.";
                }
            } else {
                echo "Token inválido o expirado.";
            }
        } else {
            echo "Las contraseñas no coinciden.";
        }
    } else {
        echo "Datos incompletos.";
    }
}

$conn->close();
?>
