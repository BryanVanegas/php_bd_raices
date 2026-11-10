<?php
// obtenerTodosPorCorreoAnfitrion(correoAnfitrion)  ->  GET  ? correoAnfitrion=a@b.com
header("Content-Type: application/json; charset=utf-8");

include 'conexion.php';

$correoAnfitrion = $_GET['correo_anfitrion'];

$resultado = mysqli_query($conn, 
                            "SELECT * FROM servicios
                                WHERE correo_anfitrion = '$correoAnfitrion'"
                        );

$servicios = array();

while($row = mysqli_fetch_assoc($resultado)) {
    $servicios[] = $row;
}

echo json_encode($servicios);
?>