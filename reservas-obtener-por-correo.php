<?php

header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$correo = $_GET['correo'] ?? '';

$sql = "SELECT * FROM reservas
        WHERE correoExplorador = ?
        ORDER BY fechaReserva ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$reservas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $reservas[] = $fila;
}

echo json_encode($reservas, JSON_UNESCAPED_UNICODE);

mysqli_stmt_close($stmt);
?>
