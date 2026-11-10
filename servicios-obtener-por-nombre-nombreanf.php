<?php
// 1. Indicar a Android que la respuesta será un JSON
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

// 2. Validar que el parámetro exista para evitar errores
$query_param = isset($_GET['query']) ? $_GET['query'] : '';

// 3. Preparar el texto de búsqueda de forma segura para el LIKE (ej: %Juan%)
$like_param = "%" . $query_param . "%";

// 4. Usar una consulta preparada (Prepared Statement) para evitar inyección SQL
$stmt = mysqli_prepare(
    $conn,
    "SELECT * 
        FROM servicios 
        WHERE nombre 
        LIKE ? OR nombre_anfitrion LIKE ?"
);

// "ss" significa que pasamos dos parámetros de tipo string
mysqli_stmt_bind_param($stmt, "ss", $like_param, $like_param);

// 5. Ejecutar la consulta
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

// 6. Guardar TODOS los resultados en un array
$servicios = array();
while ($row = mysqli_fetch_assoc($resultado)) {
    $servicios[] = $row;
}

// 7. Enviar la lista completa a Android en formato JSON
echo json_encode($servicios);
