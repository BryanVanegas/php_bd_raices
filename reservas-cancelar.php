
<?php

header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$id = $_POST['id'] ?? null;
$correo = $_POST['correoExplorador'] ?? '';

if (!$id || !$correo) {
    http_response_code(400);
    echo json_encode(["mensaje" => "DATOS_INCOMPLETOS"]);
    exit;
}

$sql = "DELETE FROM reservas
        WHERE id = ? AND correoExplorador = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $id, $correo);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["mensaje" => "OK"]);
    } else {
        http_response_code(404);
        echo json_encode(["mensaje" => "NO_ENCONTRADA"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["mensaje" => "ERROR"]);
}

mysqli_stmt_close($stmt);
?>
