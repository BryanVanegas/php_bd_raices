<?php

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correo = $_POST['correo'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT * 
    FROM usuarios
    WHERE correo = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $correo
);

if (mysqli_stmt_execute($stmt)) {
    // 1. Obtener el resultado de la sentencia preparada
    $result = mysqli_stmt_get_result($stmt);

    // 2. Extraer los datos de forma asociativa (sin duplicados)
    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
} else {
    echo json_encode(["mensaje" => "ERROR"]);
}
