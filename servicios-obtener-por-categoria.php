<?php
// obtenerTodosPorCategoria(categoria)  ->  GET  ?categoria=GASTRONOMIA
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$categoria = $_GET['categoria'];

$resultado = mysqli_query($conn, "SELECT * FROM servicios WHERE categoria = '$categoria'");

$servicios = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    $servicios[] = $row;
}

echo json_encode($servicios);
?>