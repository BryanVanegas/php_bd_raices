<?php
require __DIR__ . '/config.php';
soloMetodo('GET');

$correo = correoValido($_GET['correo'] ?? '');

$st = db()->prepare(
    'SELECT g.id, g.nombre, g.descripcion, g.estado, g.correo_creador AS correoCreador
       FROM grupos_viaje g
       INNER JOIN miembros_grupo m ON m.grupo_id = g.id
      WHERE m.correo_usuario = ?
      ORDER BY g.id DESC'
);
$st->execute([$correo]);
responder($st->fetchAll());
