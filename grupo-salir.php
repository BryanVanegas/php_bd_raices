<?php
// salirGrupo()  ->  POST
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$grupoId = (int)$_POST['grupoId'];
$correo  = $_POST['correo'];

$stmt = mysqli_prepare($conn, "DELETE FROM miembros_grupo WHERE grupoId = ? AND correoUsuario = ?");
mysqli_stmt_bind_param($stmt, "is", $grupoId, $correo);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
}

mysqli_stmt_close($stmt);
?>