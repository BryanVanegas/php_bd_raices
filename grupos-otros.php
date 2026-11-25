<?php
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';


$sql = "SELECT *
        FROM grupos_viaje
        ";

$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
    exit;
}

if (mysqli_stmt_execute($stmt)) {
    $resultado = mysqli_stmt_get_result($stmt);
    $grupos = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $grupos[] = $fila;
    }

    echo json_encode($grupos);
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
}

mysqli_stmt_close($stmt);
