<?php
// Actualiza la información de un EXPLORADOR (Editar perfil y Preferencias de viaje).
// La app envía el usuario completo con los cambios aplicados.
// El correo identifica al usuario y no se modifica.

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correo = $_POST['correo'] ?? '';

if ($correo === '') {
    echo json_encode(["mensaje" => "ERROR: falta el correo"]);
    exit;
}

$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$intereses = $_POST['intereses'] ?? '';
$sobreMi = $_POST['sobreMi'] ?? '';
$lenguas = $_POST['lenguas'] ?? '';
$genero = $_POST['genero'] ?? '';

// AND tipoUsuario = 'EXPLORADOR' evita editar por error a un anfitrión
$stmt = mysqli_prepare(
    $conn,
    "UPDATE usuarios
     SET nombre = ?,
         telefono = ?,
         direccion = ?,
         intereses = ?,
         sobreMi = ?,
         lenguas = ?,
         genero = ?
     WHERE correo = ?
     AND tipoUsuario = 'EXPLORADOR'"
);

if (!$stmt) {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "ssssssss",
    $nombre,
    $telefono,
    $direccion,
    $intereses,
    $sobreMi,
    $lenguas,
    $genero,
    $correo
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_stmt_error($stmt)]);
}

?>