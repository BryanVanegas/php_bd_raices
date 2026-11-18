<?php
// Elimina la cuenta de un usuario (EXPLORADOR o ANFITRION).
// Recibe: correo.

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$correo = $_POST['correo'] ?? '';

if ($correo === '') {
    echo json_encode(["mensaje" => "ERROR: falta el correo"]);
    exit;
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM usuarios
     WHERE correo = ?"
);

if (!$stmt) {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $correo);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["mensaje" => "OK"]);
    } else {
        echo json_encode(["mensaje" => "ERROR: usuario no encontrado"]);
    }
} else {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_stmt_error($stmt)]);
}

?>