<?php
session_start();

// Límite de aplicaciones abiertas
$max_apps = 2;

// Verificamos si ya ha alcanzado el límite
if ($_SESSION['app_count'] >= $max_apps) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Has alcanzado el límite de aplicaciones abiertas. Cierra alguna antes de abrir una nueva.'
    ]);
    exit(); // Finaliza el script si se ha alcanzado el límite
}

// Incrementa el contador de aplicaciones abiertas
$_SESSION['app_count']++;

// Aquí puedes añadir el código para cargar la aplicación, si es necesario

echo json_encode([
    'status' => 'success',
    'message' => 'Aplicación abierta con éxito.'
]);
?>
