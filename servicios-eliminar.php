<?php
// eliminar(servicio) -> POST id=5
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$id = $_POST['id'];

$query = "DELETE FROM servicios
            WHERE id = '$id'";

if(mysqli_query($conn, $query)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    echo json_encode(["mensaje" => "ERROR"]);
}
?>