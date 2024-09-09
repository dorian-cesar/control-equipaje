<?php
header("Access-Control-Allow-Origin: *"); // Permitir acceso desde cualquier origen
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");  // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Encabezados permitidos

// Recibimos los datos del formulario vía POST
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$asiento = $_POST['asiento'];
$servicio = $_POST['servicio'];
$equipaje = $_POST['equipaje'];
$fechaHoraViaje = $_POST['fechaHoraViaje'];

// Obtenemos el número de equipaje a imprimir
$pieza = $_POST['pieza']; // El número de la pieza de equipaje a imprimir

// Generamos el código único de equipaje para la pieza actual
$codigoEquipajePieza = $servicio . '-' . $rut . '-' . $pieza;

// Imprimimos los detalles del ticket de equipaje
echo "<h4>Ticket de Equipaje $pieza</h4>";
echo "<p>Nombre: $nombre</p>";
echo "<p>RUT: $rut</p>";
echo "<p>Origen: $origen</p>";
echo "<p>Destino: $destino</p>";
echo "<p>Número de Asiento: $asiento</p>";
echo "<p>Número de Boleto: $servicio</p>";
echo "<p>Pieza de Equipaje: $pieza de $equipaje</p>";
echo "<p>Fecha y Hora del Viaje: $fechaHoraViaje</p>";
echo "<p>Código de Equipaje: $codigoEquipajePieza</p>";

// Generamos el código QR para la pieza de equipaje
echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.$codigoEquipajePieza.'" alt="QR Code" />';
echo '<br><br>';
?>
