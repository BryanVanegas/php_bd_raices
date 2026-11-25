<?php
// enviarMensaje()  ->  POST
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$grupoId = isset($_POST['grupoId']) ? (int)$_POST['grupoId'] : 0;
$correo  = isset($_POST['correoAutor']) ? trim($_POST['correoAutor']) : '';
$nombre  = isset($_POST['nombreAutor']) ? trim($_POST['nombreAutor']) : '';
$genero  = isset($_POST['generoAutor']) ? strtoupper(trim($_POST['generoAutor'])) : 'M';
$texto   = isset($_POST['texto']) ? trim($_POST['texto']) : '';

if ($grupoId <= 0 || $correo == '' || $nombre == '' || $texto == '' || strlen($texto) > 1000) {
    http_response_code(400);
    echo json_encode(["mensaje" => "Datos inválidos"]);
    exit;
}

// Insertar mensaje (fecha en milisegundos)
$fecha = (int)round(microtime(true) * 1000);

$stmt = mysqli_prepare($conn, "INSERT INTO mensajes_grupo (grupoId, correoAutor, nombreAutor, generoAutor, texto, fecha) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "issssi", $grupoId, $correo, $nombre, $genero, $texto, $fecha);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
}

mysqli_stmt_close($stmt);
?>
