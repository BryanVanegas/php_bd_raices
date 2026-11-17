<?php
require __DIR__ . '/config.php';
soloMetodo('GET');

$grupoId = (int)($_GET['grupo_id'] ?? 0);
if ($grupoId <= 0) {
    fallo('Falta grupo_id');
}

// Últimos 200 mensajes, devueltos del más antiguo al más reciente.
$st = db()->prepare(
    'SELECT * FROM (
        SELECT id, grupo_id AS grupoId, correo_autor AS correoAutor,
               nombre_autor AS nombreAutor, genero_autor AS generoAutor, texto, fecha
          FROM mensajes_grupo
         WHERE grupo_id = ?
         ORDER BY fecha DESC, id DESC
         LIMIT 200
     ) t
     ORDER BY fecha ASC, id ASC'
);
$st->execute([$grupoId]);
responder($st->fetchAll());
