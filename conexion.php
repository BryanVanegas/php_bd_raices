<?php
$conn = mysqli_connect("localhost", "root", "rootadmin", "php_raices_bd");

mysqli_set_charset($conn, "utf8mb4");

// if (!$conn) {
//     die("Error al conectar con la base de datos: " . mysqli_connect_error());
// } else {
//     echo "¡Conexión exitosa desde PHP hacia MySQL Workbench! \n";
// }
?>