<?php
// insertar(servicio)  ->  POST
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$nombre           = $_POST['nombre'] ?? '';
$descripcion      = $_POST['descripcion'] ?? '';
$categoria        = $_POST['categoria'] ?? '';
$nombre_anfitrion = $_POST['nombre_anfitrion'] ?? '';
$correo_anfitrion = $_POST['correo_anfitrion'] ?? '';
$precio           = (float)($_POST['precio'] ?? 0);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO servicios
        (nombre, descripcion, categoria, nombre_anfitrion, correo_anfitrion, precio)
     VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssd",
    $nombre,
    $descripcion,
    $categoria,
    $nombre_anfitrion,
    $correo_anfitrion,
    $precio
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK", "id" => mysqli_insert_id($conn)]);
} else {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_stmt_error($stmt)]);
}
