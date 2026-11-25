<?php
// obtenerMensajes()  ->  GET
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$grupoId = 0;
if (isset($_GET['grupoId'])) {
    $grupoId = (int)$_GET['grupoId'];
}

if ($grupoId <= 0) {
    http_response_code(400);
    echo json_encode(["mensaje" => "Falta grupo_id"]);
    exit;
}

// Últimos 200 mensajes, del más antiguo al más reciente
$sql = "SELECT * FROM (
            SELECT id, grupoId, correoAutor,
                    nombreAutor, generoAutor, texto, fecha
            FROM mensajes_grupo
            WHERE grupoId = ?
            ORDER BY fecha DESC, id DESC
            LIMIT 200
        ) t
        ORDER BY fecha ASC, id ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $grupoId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$mensajes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $mensajes[] = $row;
}

echo json_encode($mensajes);

mysqli_stmt_close($stmt);
?>