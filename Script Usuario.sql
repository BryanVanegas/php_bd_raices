CREATE DATABASE php_raices_bd;

USE php_raices_bd;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(150) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,

    contrasena VARCHAR(120) NOT NULL,

    direccion VARCHAR(250) NOT NULL,

    intereses TEXT,

    oficio TEXT,

    tipoUsuario VARCHAR(20) NOT NULL,

    sobreMi TEXT,

    lenguas TEXT,

    genero VARCHAR(10)
);