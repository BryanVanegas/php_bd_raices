
<?php

header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$servicioId = $_POST['servicioId'] ?? null;
$nombreServicio = $_POST['nombreServicio'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$nombreAnfitrion = $_POST['nombreAnfitrion'] ?? '';
$correoExplorador = $_POST['correoExplorador'] ?? '';
$fechaReserva = $_POST['fechaReserva'] ?? null;
$personas = $_POST['personas'] ?? null;
$precioUnitario = $_POST['precioUnitario'] ?? null;
$notas = trim($_POST['notas'] ?? '');

if (
    !$servicioId ||
    !$nombreServicio ||
    !$categoria ||
    !$nombreAnfitrion ||
    !$correoExplorador ||
    !$fechaReserva ||
    !$personas ||
    $precioUnitario === null
) {
    http_response_code(400);
    echo json_encode(["mensaje" => "DATOS_INCOMPLETOS"]);
    exit;
}

$total = (float)$precioUnitario * (int)$personas;

$sql = "INSERT INTO reservas (
    servicioId,
    nombreServicio,
    categoria,
    nombreAnfitrion,
    correoExplorador,
    fechaReserva,
    personas,
    precioUnitario,
    total,
    notas
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "issssiidds",
    $servicioId,
    $nombreServicio,
    $categoria,
    $nombreAnfitrion,
    $correoExplorador,
    $fechaReserva,
    $personas,
    $precioUnitario,
    $total,
    $notas
);

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
?>
