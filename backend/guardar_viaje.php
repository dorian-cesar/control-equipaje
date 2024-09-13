<?php
// Conexión a la base de datos
include 'conexion.php';

// Verificar si los datos del formulario han sido enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha_hora_viaje = $_POST['fechaHoraViaje'];
    $cod_servicio = $_POST['codServicio'];
    $patente = $_POST['patente'];
    $conductor = $_POST['conductor'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO viajes (origen, destino, fecha_hora_viaje, cod_servicio, patente, conductor)
            VALUES ('$origen', '$destino', '$fecha_hora_viaje', '$cod_servicio', '$patente', '$conductor')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "El viaje ha sido guardado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
