<?php
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
