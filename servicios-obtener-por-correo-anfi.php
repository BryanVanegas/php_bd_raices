<?php
// obtenerTodosPorCorreoAnfitrion(correoAnfitrion)  ->  GET  ?correoAnfitrion=a@b.com
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correoAnfitrion = $_GET['correoAnfitrion'];

$resultado = mysqli_query($conn, "SELECT * FROM servicios WHERE correoAnfitrion = '$correoAnfitrion'");

$servicios = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    $servicios[] = $row;
}

echo json_encode($servicios);
?>