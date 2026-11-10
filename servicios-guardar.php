<?php
// insertar(servicio)  ->  POST  body JSON: {"nombre": "...", ...}
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$nombre_anfitrion = $_POST['nombre_anfitrion'];
$correo_anfitrion = $_POST['correo_anfitrion'];
$precio = $_POST['precio'];

$query = "INSERT INTO persona 
            VALUES(
            '$nombre',
            '$descripcion',
            '$categoria',
            '$nombre_anfitrion',
            '$correo_anfitrion',
            '$precio')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    echo json_encode(["mensaje" => "ERROR"]);
}
?>