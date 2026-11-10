<?php
// obtenerTodos() y obtenerTodosAsList()  ->  GET
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$result = mysqli_query($conn, "SELECT * FROM servicios");

$servicios = array();

while ($row = mysqli_fetch_assoc($result)) {
    $servicios[] = $row;
}

echo json_encode($servicios);
?>