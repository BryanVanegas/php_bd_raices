<?php
require __DIR__ . '/config.php';
soloMetodo('POST');

$grupoId = (int)($_POST['grupoId'] ?? 0);
$correo  = correoValido($_POST['correoAutor'] ?? '');
$nombre  = trim((string)($_POST['nombreAutor'] ?? ''));
$genero  = strtoupper(trim((string)($_POST['generoAutor'] ?? 'M')));
$texto   = trim((string)($_POST['texto'] ?? ''));

if ($grupoId <= 0)                               fallo('Falta grupoId');
if ($nombre === '' || mb_strlen($nombre) > 100)  fallo('Nombre de autor inválido');
if ($texto === '' || mb_strlen($texto) > 1000)   fallo('El mensaje debe tener entre 1 y 1000 caracteres');
if (!in_array($genero, ['M', 'F'], true))        $genero = 'M';

$st = db()->prepare('SELECT 1 FROM miembros_grupo WHERE grupo_id = ? AND correo_usuario = ?');
$st->execute([$grupoId, $correo]);
if (!$st->fetch()) {
    fallo('No perteneces a este grupo', 403);
}

db()->prepare(
    'INSERT INTO mensajes_grupo (grupo_id, correo_autor, nombre_autor, genero_autor, texto, fecha)
     VALUES (?, ?, ?, ?, ?, ?)'
)->execute([$grupoId, $correo, $nombre, $genero, $texto, (int)round(microtime(true) * 1000)]);

responder(['mensaje' => 'OK']);