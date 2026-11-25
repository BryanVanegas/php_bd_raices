<?php
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["mensaje" => "METODO_NO_PERMITIDO"]);
    exit;
}

$nombre      = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$correo      = trim($_POST['correoCreador'] ?? '');

if (!$nombre || !$correo || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["mensaje" => "DATOS_INCOMPLETOS"]);
    exit;
}

// Ajustado a los límites reales de tu CREATE TABLE (VARCHAR 100 y 250)
if (mb_strlen($nombre) > 100 || mb_strlen($descripcion) > 250) {
    http_response_code(400);
    echo json_encode(["mensaje" => "DATOS_EXCEDEN_LONGITUD"]);
    exit;
}

$estado = "PLANEANDO";
$sql = "INSERT INTO grupos_viaje (nombre, descripcion, estado, correoCreador)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
    exit;
}

mysqli_stmt_bind_param($stmt, "ssss", $nombre, $descripcion, $estado, $correo);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "mensaje" => "OK",
        "id" => mysqli_insert_id($conn)
    ]);
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
}

mysqli_stmt_close($stmt);
