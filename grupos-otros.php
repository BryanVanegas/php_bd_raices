<?php
require __DIR__ . '/config.php';
soloMetodo('GET');

$correo = correoValido($_GET['correo'] ?? '');

$st = db()->prepare(
    'SELECT id, nombre, descripcion, estado, correo_creador AS correoCreador
       FROM grupos_viaje
      WHERE id NOT IN (SELECT grupo_id FROM miembros_grupo WHERE correo_usuario = ?)
      ORDER BY id DESC'
);
$st->execute([$correo]);
responder($st->fetchAll());
