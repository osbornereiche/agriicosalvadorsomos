<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function start_admin_session(): void
{
    $cfg = app_config()['app'];
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name($cfg['session_name'] ?? 'supervielle_admin');
        session_start();
    }
}

function panel_logged_in(): bool
{
    start_admin_session();
    return !empty($_SESSION['admin_id']);
}

function require_panel(): void
{
    if (!panel_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function current_admin(): ?array
{
    if (!panel_logged_in()) {
        return null;
    }
    $stmt = db()->prepare('SELECT * FROM administradores WHERE id = ? AND activo = 1 LIMIT 1');
    $stmt->execute([(int) $_SESSION['admin_id']]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function login_admin(string $usuario, string $password): bool
{
    $stmt = db()->prepare('SELECT * FROM administradores WHERE usuario = ? AND activo = 1 LIMIT 1');
    $stmt->execute([$usuario]);
    $admin = $stmt->fetch();
    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        return false;
    }
    start_admin_session();
    $_SESSION['admin_id'] = (int) $admin['id'];
    $_SESSION['admin_nombre'] = $admin['nombre'];
    return true;
}

function logout_admin(): void
{
    start_admin_session();
    $_SESSION = [];
    session_destroy();
}
