<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php'; // Tu archivo de conexión a la base de datos

$correo = $_POST['correo'];
$password = $_POST['password'];

if (empty($correo) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor, complete todos los campos.']);
    exit;
}

// Consulta para validar el usuario
$sql = "SELECT * FROM empresas WHERE correo = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verificar la contraseña (asumiendo que está hasheada con password_hash)
    if (password_verify($password, $row['password'])) {
        echo json_encode([
            'status' => 'success',
            'correo' => $row['correo']
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["status" => 'error', "message" => 'El correo no está registrado.']);
}

$stmt->close();
$conn->close();
?>
