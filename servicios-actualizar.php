<?php
// actualizar(servicio)  ->  POST
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];

// $query = "UPDATE servicios SET
//                 nombre = '$nombre',
//                 descripcion = '$descripcion',
//                 categoria = '$categoria',
//                 precio = '$precio'
//             WHERE id = '$id'";

// if (mysqli_query($conn, $query)) {
//     echo json_encode(["mensaje" => "OK"]);
// } else {
//     echo json_encode(['mensaje' => 'ERROR']);
// }


//Metodo para evitar sqlinjection
$stmt = mysqli_prepare(
    $conn,
    "UPDATE servicios
    SET nombre = ?, descripcion = ?, categoria = ?, precio = ?
    WHERE id = ?"
);

if (!$stmt) {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssdi", $nombre, $descripcion, $categoria, $precio, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["mensaje" => "OK"]);
} else {
    echo json_encode(["mensaje" => "ERROR: " . mysqli_stmt_error($stmt)]);
}
