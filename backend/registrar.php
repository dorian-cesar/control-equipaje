<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'conexion.php';
date_default_timezone_set('America/Santiago');

// Recibir los datos enviados por POST
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$asiento = $_POST['asiento'];
$servicio = $_POST['servicio'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$equipaje = $_POST['equipaje'];
$fechaHoraViaje = $_POST['fechaHoraViaje'];
$fechaHoraRegistro = date('Y-m-d H:i:s');
$patente = $_POST['patente'];
$conductor = $_POST['conductor'];
$codServicio = $_POST['codServicio'];
$rut_conductor = $_POST['rut_conductor'];

// Generar un código de equipaje único por pasajero (sin incluir el número de equipaje aquí)
$codigoEquipajeBase = $servicio . '-' . $rut;

// Insertar el registro del pasajero en la base de datos
$sql = "INSERT INTO registros 
(rut, nombre, origen, destino, asiento, servicio, equipaje, codigo_equipaje, fecha_hora_viaje, fecha_hora_registro,correo, telefono,conductor,patente,cod_servicio,rut_conductor) 
        VALUES 
('$rut', '$nombre', '$origen', '$destino', '$asiento', '$servicio', '$equipaje', '$codigoEquipajeBase', '$fechaHoraViaje', '$fechaHoraRegistro','$correo','$telefono','$conductor','$patente','$codServicio','$rut_conductor')";

if ($conn->query($sql) === TRUE) {
    // Mostrar los datos del pasajero y el número total de piezas de equipaje
  
    echo '<img src="https://araucania.wit.la/control-equipaje/assets/andesmar.jpg" alt="">';
    echo "<h6>Comprobante del Usuario</h6>";
    echo "<p>#Boleto: $servicio</p>";
    echo "<p>Nombre: $nombre</p>";
    echo "<p>RUT: $rut</p>";
    echo "<p>Fecha y Hora del Viaje: $fechaHoraViaje</p>";
    echo "<p>Total de Piezas de Equipaje: $equipaje</p>";
    echo "<p>Código Base de Equipaje: $codigoEquipajeBase</p>";
 //   echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.$servicio.'" alt="QR Code" />';
    echo "<p>--------------------------</p>";
} else {
    // En caso de error en la inserción
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
