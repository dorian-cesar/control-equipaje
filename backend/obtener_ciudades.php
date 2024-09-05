<?php

header('Access-Control-Allow-Origin: *'); // Permitir todas las orígenes
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Permitir los métodos HTTP
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Permitir las cabeceras
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
