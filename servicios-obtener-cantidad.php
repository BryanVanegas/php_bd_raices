<?php
// obtenerCantidadServicios()  ->  GET
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$resultado = mysqli_query($conn, "SELECT COUNT(*) AS cantidad FROM servicios");
$fila = mysqli_fetch_assoc($resultado);

echo json_encode(["cantidad" => (int)$fila['cantidad']]);

// CAMBIO: Imprime directamente el número codificado en JSON
//echo json_encode((int)$fila['cantidad']); 
?>