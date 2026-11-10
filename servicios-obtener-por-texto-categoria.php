<?php
// obtenerTodosPorTextoYCategoria(query, categoria)  ->  GET  ?query=juan&categoria=GASTRONOMIA
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$query = $_GET['query'];
$categoria = $_GET['categoria'];

$resultado = mysqli_query($conn, "SELECT * FROM servicios
    WHERE (nombre LIKE '%$query%' OR nombre_anfitrion LIKE '%$query%')
        AND categoria = '$categoria'");

$servicios = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    $servicios[] = $row;
}

echo json_encode($servicios);
