<?php
include 'conexion.php';

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM servicios WHERE id='$id'");

$row = mysqli_fetch_array($result);

echo json_encode($row);
?>