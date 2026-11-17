<?php
require __DIR__ . '/config.php';
soloMetodo('POST');

$grupoId = (int)($_POST['grupoId'] ?? 0);
$correo  = correoValido($_POST['correo'] ?? '');
if ($grupoId <= 0) {
    fallo('Falta grupoId');
}

$pdo = db();
$pdo->beginTransaction();
try {
    $st = $pdo->prepare('SELECT id FROM grupos_viaje WHERE id = ? FOR UPDATE');
    $st->execute([$grupoId]);
    if (!$st->fetch()) {
        $pdo->rollBack();
        fallo('El grupo no existe', 404);
    }

    $pdo->prepare('INSERT IGNORE INTO miembros_grupo (grupo_id, correo_usuario) VALUES (?, ?)')
        ->execute([$grupoId, $correo]);

    $st = $pdo->prepare('SELECT COUNT(*) FROM miembros_grupo WHERE grupo_id = ?');
    $st->execute([$grupoId]);
    if ((int)$st->fetchColumn() >= 2) {
        $pdo->prepare('UPDATE grupos_viaje SET estado = \'ACTIVO\' WHERE id = ?')
            ->execute([$grupoId]);
    }
    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    throw $e;
}

responder(['mensaje' => 'OK']);