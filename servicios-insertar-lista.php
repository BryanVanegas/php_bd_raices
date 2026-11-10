<?php
header("Content-Type: application/json; charset=UTF-8");
include 'conexion.php';

$servicios = json_decode(file_get_contents('php://input'), true);
$ok = true;

if (is_array($servicios)) {
    // Preparamos la consulta una sola vez
    $stmt = mysqli_prepare($conn, "INSERT INTO servicios (
                                                nombre, 
                                                descripcion, 
                                                categoria, 
                                                nombre_anfitrion, 
                                                correo_anfitrion, 
                                                precio
                                            ) 
                                        VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($servicios as $s) {
        // Vinculamos los parámetros de forma segura (s = string, d = double)
        mysqli_stmt_bind_param(
            $stmt,
            "sssssd",
            $s['nombre'],
            $s['descripcion'],
            $s['categoria'],
            $s['nombre_anfitrion'],
            $s['correo_anfitrion'],
            $s['precio']
        );

        if (!mysqli_stmt_execute($stmt)) {
            $ok = false;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    $ok = false;
}

echo json_encode(["mensaje" => $ok ? "OK" : "ERROR"]);
