<?php
// unirseGrupo()  ->  POST
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$grupoId = isset($_POST['grupoId']) ? (int)$_POST['grupoId'] : 0;
$correo  = isset($_POST['correo']) ? trim($_POST['correo']) : '';

if ($grupoId <= 0 || $correo == '') {
    http_response_code(400);
    echo json_encode(["mensaje" => "Faltan datos"]);
    exit;
}

// Verificar que el grupo existe
$stmt = mysqli_prepare($conn, "SELECT id FROM grupos_viaje WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $grupoId);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
if (mysqli_stmt_num_rows($stmt) == 0) {
    mysqli_stmt_close($stmt);
    http_response_code(404);
    echo json_encode(["mensaje" => "El grupo no existe"]);
    exit;
}
mysqli_stmt_close($stmt);

// Agregar miembro (IGNORE evita duplicados si hay clave única)
$stmt = mysqli_prepare($conn, "INSERT IGNORE INTO miembros_grupo (grupo_id, correo_usuario) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "is", $grupoId, $correo);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Contar miembros
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM miembros_grupo WHERE grupo_id = ?");
mysqli_stmt_bind_param($stmt, "i", $grupoId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $total);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Con 2 o más miembros el grupo pasa a ACTIVO
if ($total >= 2) {
    $stmt = mysqli_prepare($conn, "UPDATE grupos_viaje SET estado = 'ACTIVO' WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $grupoId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

echo json_encode(["mensaje" => "OK"]);
?>