<?php

header("Access-Control-Allow-Origin: https://control-equipaje.netlify.app"); // Permite solicitudes desde cualquier origen
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");  // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Encabezados permitidos


include 'conexion.php';

date_default_timezone_set('America/Santiago');

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$asiento = $_POST['asiento'];
$servicio = $_POST['servicio'];
$equipaje = $_POST['equipaje'];
$fechaHoraViaje = $_POST['fechaHoraViaje'];
$fechaHoraRegistro = date('Y-m-d H:i:s');

// Iniciamos la salida HTML para los tickets
echo "<h3>Tickets de Equipaje</h3>";

// Generamos y registramos un ticket por cada pieza de equipaje

    // Generamos un código de equipaje único por pieza
    $codigoEquipaje = $servicio . '-' . $rut ;

    // Insertamos el ticket en la base de datos
    
    $sql = "INSERT INTO registros (rut, nombre, origen, destino, asiento, servicio, equipaje, codigo_equipaje, fecha_hora_viaje, fecha_hora_registro) 
            VALUES ('$rut', '$nombre', '$origen', '$destino', '$asiento', '$servicio', '$equipaje', '$codigoEquipaje', '$fechaHoraViaje', '$fechaHoraRegistro')";


    if ($conn->query($sql) === TRUE) {
        for ($i = 1; $i <= $equipaje; $i++) {
        // Mostramos la información del ticket
        echo "<div class='ticket'>";
        echo "<p>Nombre: $nombre";
        echo "<p>RUT: $rut</p>";
        echo "<p>Origen: $origen</p>";
        echo "<p>Destino: $destino</p>";
        echo "<p>Fecha y Hora del Viaje: $fechaHoraViaje</p>";
        echo "<p>Número de Asiento: $asiento</p>";
        echo "<p>Número de Boleto: $servicio</p>";
        echo "<p>Pieza de Equipaje: $i de $equipaje</p>";
        echo "<p>Código de Equipaje: $codigoEquipaje</p>";
       // echo "<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=$codigoEquipaje' alt='QR Code' /><br><br>";
       // echo '<br>';
       // echo '<hr>';
       // echo "</div>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


// Cerramos la conexión a la base de datos
$conn->close();
?>
