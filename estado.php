<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/monitor.php';

header('Content-Type: application/json; charset=utf-8');

if (!panel_logged_in()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$input = json_decode(file_get_contents('php://input') ?: '', true);
if (!is_array($input)) {
    $input = $_POST;
}

$accion = (string) ($input['accion'] ?? '');
$id = (int) ($input['id'] ?? 0);

if ($id <= 0 || !in_array($accion, ['rechazar', 'eliminar'], true)) {
    echo json_encode(['ok' => false, 'error' => 'Datos inválidos']);
    exit;
}

try {
    if ($accion === 'rechazar') {
        $ok = rechazar_evento($id);
        echo json_encode([
            'ok' => $ok,
            'accion' => 'rechazar',
            'id' => $id,
            'mensaje' => $ok ? 'Usuario notificado: login inválido' : 'No se pudo rechazar',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $ok = eliminar_evento($id);
    echo json_encode([
        'ok' => $ok,
        'accion' => 'eliminar',
        'id' => $id,
        'mensaje' => $ok ? 'Fila eliminada del panel' : 'No se pudo eliminar',
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Error en la acción']);
}
