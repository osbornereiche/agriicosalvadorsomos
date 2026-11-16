<?php
declare(strict_types=1);

function app_config(): array
{
    static $config = null;
    if ($config !== null) {
        return $config;
    }

    $path = dirname(__DIR__) . '/config/config.php';
    if (!is_file($path)) {
        throw new RuntimeException('Falta config/config.php. Ejecute el instalador en /install/');
    }

    $config = require $path;
    date_default_timezone_set($config['app']['timezone'] ?? 'America/Argentina/Buenos_Aires');
    return $config;
}

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $c = app_config()['db'];
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $c['host'],
        (int) ($c['port'] ?? 3306),
        $c['name'],
        $c['charset'] ?? 'utf8mb4'
    );

    $pdo = new PDO($dsn, $c['user'], $c['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function client_ip(): string
{
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }
        $value = trim(explode(',', (string) $_SERVER[$key])[0]);
        if (filter_var($value, FILTER_VALIDATE_IP)) {
            return $value;
        }
    }
    return '0.0.0.0';
}

function json_response(array $data, int $code = 200): never
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function format_datetime(?string $dt): string
{
    if (!$dt) {
        return '—';
    }
    $ts = strtotime($dt);
    return $ts ? date('d/m/Y H:i:s', $ts) : $dt;
}

function parse_user_agent(string $ua): array
{
    $ua = $ua ?: 'Desconocido';
    $navegador = 'Otro';
    $dispositivo = 'Escritorio';

    if (preg_match('/Edg\/(\d+)/i', $ua)) {
        $navegador = 'Edge';
    } elseif (preg_match('/Chrome\/(\d+)/i', $ua)) {
        $navegador = 'Chrome';
    } elseif (preg_match('/Firefox\/(\d+)/i', $ua)) {
        $navegador = 'Firefox';
    } elseif (preg_match('/Safari\/(\d+)/i', $ua) && !preg_match('/Chrome/i', $ua)) {
        $navegador = 'Safari';
    }

    if (preg_match('/Mobile|Android|iPhone|iPad/i', $ua)) {
        $dispositivo = preg_match('/iPad|Tablet/i', $ua) ? 'Tablet' : 'Móvil';
    }

    return [
        'navegador' => mb_substr($navegador, 0, 120),
        'dispositivo' => mb_substr($dispositivo, 0, 120),
    ];
}

/** Opciones cURL compatibles con WAMP (certificados SSL). */
function curl_ssl_options(): array
{
    $ca = dirname(__DIR__) . '/config/cacert.pem';
    if (is_file($ca)) {
        return [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => $ca,
        ];
    }

    // Fallback local si no hay cacert (evita error en WAMP)
    return [
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
    ];
}

/**
 * @return array{ok:bool, http?:int, error?:string}
 */
function discord_webhook_post(string $webhookUrl, array $payload): array
{
    $ch = curl_init($webhookUrl);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
    ] + curl_ssl_options());

    $body = curl_exec($ch);
    $errno = curl_errno($ch);
    $error = curl_error($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($errno) {
        // Reintento sin verificación SSL (común en WAMP Windows)
        $ch = curl_init($webhookUrl);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ]);
        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($errno) {
            return ['ok' => false, 'error' => $error ?: 'Error cURL'];
        }
    }

    if ($code < 200 || $code >= 300) {
        return ['ok' => false, 'http' => $code, 'error' => 'HTTP ' . $code . ($body ? ': ' . mb_substr((string) $body, 0, 120) : '')];
    }

    return ['ok' => true, 'http' => $code];
}

function discord_notify(string $title, string $description, array $fields = []): void
{
    $cfg = app_config()['discord'] ?? [];
    if (empty($cfg['enabled']) || empty($cfg['webhook_url'])) {
        return;
    }

    $embedFields = [];
    foreach ($fields as $name => $value) {
        $embedFields[] = [
            'name' => (string) $name,
            'value' => mb_substr((string) $value, 0, 1024) ?: '—',
            'inline' => true,
        ];
    }

    $payload = [
        'username' => 'Supervielle Monitor',
        'embeds' => [[
            'title' => $title,
            'description' => $description,
            'color' => 9043995, // burgundy
            'fields' => $embedFields,
            'timestamp' => gmdate('c'),
        ]],
    ];

    discord_webhook_post((string) $cfg['webhook_url'], $payload);
}
