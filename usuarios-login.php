<?php

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM usuarios
     WHERE correo = ?
     AND contrasena = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $correo,
    $contrasena
);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($resultado)) {

    echo json_encode([
        "mensaje" => "OK",
        "usuario" => $row
    ]);

} else {

    echo json_encode([
        "mensaje" => "ERROR"
    ]);

}

?>