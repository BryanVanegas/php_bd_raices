<?php
require __DIR__ . '/config.php';
soloMetodo('POST');

$nombre      = trim((string)($_POST['nombre'] ?? ''));
$descripcion = trim((string)($_POST['descripcion'] ?? ''));
$correo      = correoValido($_POST['correoCreador'] ?? '');

if ($nombre === '' || mb_strlen($nombre) > 120) {
    fallo('El nombre es obligatorio (máximo 120 caracteres)');
}
if (mb_strlen($descripcion) > 500) {
    fallo('La descripción es demasiado larga (máximo 500 caracteres)');
}

$pdo = db();
$pdo->beginTransaction();
try {
    $pdo->prepare(
        'INSERT INTO grupos_viaje (nombre, descripcion, estado, correo_creador)
         VALUES (?, ?, \'PLANEANDO\', ?)'
    )->execute([$nombre, $descripcion, $correo]);
    $id = (int)$pdo->lastInsertId();

    $pdo->prepare('INSERT INTO miembros_grupo (grupo_id, correo_usuario) VALUES (?, ?)')
        ->execute([$id, $correo]);
    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    throw $e;
}

responder(['mensaje' => 'OK']);