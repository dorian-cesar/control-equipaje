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
echo '<img src="https://araucania.wit.la/control-equipaje/assets/andesmar.jpg" alt="">';
echo "<p>Número de Boleto: $servicio</p>";
echo '<br>';
echo "<p>Nombre: $nombre</p>";
echo '<br>';
echo "<p>RUT: $rut</p>";
echo '<br>';
echo "<p>Origen: $origen</p>";
echo '<br>';
echo "<p>Destino: $destino</p>";
echo '<br>';
echo "<p>Número de Asiento: $asiento</p>";
echo '<br>';
echo "<p>Pieza de Equipaje: $pieza de $equipaje</p>";
echo '<br>';
echo "<p>Fecha y Hora del Viaje: $fechaHoraViaje</p>";
echo '<br>';
echo "<p>Código de Equipaje: $codigoEquipajePieza</p>";
echo '<br>';

// Generamos el código QR para la pieza de equipaje
echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.$codigoEquipajePieza.'" alt="QR Code" />';
echo '<br><br>';
?>
