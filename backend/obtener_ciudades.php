<?php
// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir los métodos de solicitud que se utilizarán
header("Access-Control-Allow-Methods:GET, POST, OPTIONS");

// Permitir ciertos encabezados en las solicitudes preflight OPTIONS, incluido Content-Type
header("Access-Control-Allow-Headers: Content-Type");
include 'conexion.php';

$sql = "SELECT nombre FROM ciudades order by nombre";
$result = $conn->query($sql);

$ciudades = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ciudades[] = $row['nombre'];
    }
}

echo json_encode($ciudades);

$conn->close();
?>
