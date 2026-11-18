<?php
// Cambia la contraseña de un usuario (EXPLORADOR o ANFITRION).
// Recibe: correo, contrasenaActual, contrasenaNueva.
// Antes de cambiarla verifica que la contraseña actual sea correcta.

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correo = $_POST['correo'] ?? '';
$contrasenaActual = $_POST['contrasenaActual'] ?? '';
$contrasenaNueva = $_POST['contrasenaNueva'] ?? '';

if ($correo === '' || $contrasenaActual === '' || $contrasenaNueva === '') {
    echo json_encode(["mensaje" => "ERROR: faltan datos"]);
    exit;
}

// 1) Verificar la contraseña actual
$stmt = mysqli_prepare(
    $conn,
    "SELECT correo
     FROM usuarios
     WHERE correo = ?
     AND contrasena = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, "ss", $correo, $contrasenaActual);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (!mysqli_fetch_assoc($resultado)) {
    echo json_encode(["mensaje" => "ERROR: la contraseña actual no es correcta"]);
    exit;
}

// 2) Guardar la nueva contraseña
$stmt = mysqli_prepare(
    $conn,
    "UPDATE usuarios
     SET contrasena = ?
     WHERE correo = ?"
);

mysqli_stmt_bind_param($stmt, "ss", $contrasenaNueva, $correo);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_stmt_error($stmt)]);
}

?>