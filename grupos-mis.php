<?php

header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$correo = $_POST['correoExplorador'] ?? '';

$correo = trim($_GET['correo'] ?? $_POST['correoExplorador'] ?? '');

if (!$correo || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["mensaje" => "DATOS_INCOMPLETOS"]);
    exit;
}

$sql = "SELECT id, nombre, descripcion, estado, correoCreador
        FROM grupos_viaje
        WHERE correoCreador = ?
        ORDER BY id DESC";

$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $correo);

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
