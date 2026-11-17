<?php
require __DIR__ . '/config.php';
soloMetodo('POST');

$grupoId = (int)($_POST['grupoId'] ?? 0);
$correo  = correoValido($_POST['correo'] ?? '');
if ($grupoId <= 0) {
    fallo('Falta grupoId');
}

db()->prepare('DELETE FROM miembros_grupo WHERE grupo_id = ? AND correo_usuario = ?')
    ->execute([$grupoId, $correo]);

responder(['mensaje' => 'OK']);