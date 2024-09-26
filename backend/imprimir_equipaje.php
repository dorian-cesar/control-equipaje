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
echo '<br>';
echo '<img src="https://araucania.wit.la/control-equipaje/assets/andesmar.jpg" alt="">';
echo '<br>';
echo "<h6>Ticket de Equipaje $pieza</h6>";
echo '<br>';
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
//echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$codigoEquipajePieza.'" alt="QR Code" />';
//echo '<br><br>';

echo "<p>Por favor:</p>";
echo "<p>Verifica que tu equipaje esté correctamente identificado.</p>";
echo "<p>La Empresa no se hace responsable por objetos de valor dentro de la maleta.</p>";
echo "<p>Revisa que esté bien cerrado.</p>";
echo "<p>¡Gracias por tu colaboración!</p>";
echo '<br><br>';

/*
"Por favor,
 verifica que tu equipaje esté correctamente identificado.
  La Empresa no se hace responsable por objetos de valor dentro de la maleta. 
  Revisa que esté bien cerrado. 
  ¡Gracias por tu colaboración!"
   */

?>
