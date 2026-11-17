<?php

header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$direccion = $_POST['direccion'];

$oficio = $_POST['oficio'];

$sobreMi = $_POST['sobreMi'];

$lenguas = $_POST['lenguas'];

$genero = $_POST['genero'];

$tipoUsuario = "ANFITRION";

$intereses = "";

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO usuarios
    (
        nombre,
        telefono,
        correo,
        contrasena,
        direccion,
        intereses,
        oficio,
        tipoUsuario,
        sobreMi,
        lenguas,
        genero
    )
    VALUES(
        ?,?,?,?,?,?,?,?,?,?,?
    )"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssssss",
    $nombre,
    $telefono,
    $correo,
    $contrasena,
    $direccion,
    $intereses,
    $oficio,
    $tipoUsuario,
    $sobreMi,
    $lenguas,
    $genero
);

if(mysqli_stmt_execute($stmt)){
    echo json_encode(["mensaje"=>"OK"]);
}else{
    echo json_encode(["mensaje"=>"ERROR"]);
}

?>
