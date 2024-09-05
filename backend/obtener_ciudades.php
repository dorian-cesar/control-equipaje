<?php
header("Access-Control-Allow-Origin: https://control-equipaje.netlify.app");  // Permite solicitudes desde cualquier origen
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");  // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Encabezados permitidos


$servername = "ls-8ce02ad0b7ea586d393e375c25caa3488acb80a5.cylsiewx0zgx.us-east-1.rds.amazonaws.com";
$username = "dbmasteruser";
$password = ':&T``E~r:r!$1c6d:m143lzzvGJ$NuP;';
$dbname = "equipaje_bus";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

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
