<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$sample = $root . '/config/config.sample.php';
$configPath = $root . '/config/config.php';
$done = is_file($configPath);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = trim($_POST['db_host'] ?? '127.0.0.1');
    $dbUser = trim($_POST['db_user'] ?? 'root');
    $dbPass = (string) ($_POST['db_pass'] ?? '');
    $dbName = trim($_POST['db_name'] ?? 'supervielle_personas');
    $adminUser = trim($_POST['admin_user'] ?? 'gerente');
    $adminPass = (string) ($_POST['admin_pass'] ?? '');
    $adminNombre = trim($_POST['admin_nombre'] ?? 'Gerente');
    $discordUrl = trim($_POST['discord_webhook'] ?? '');
    $discordEnabled = !empty($_POST['discord_enabled']) && $discordUrl !== '';

    if ($adminUser === '' || strlen($adminPass) < 6) {
        $error = 'Usuario gerente y contraseña (mín. 6 caracteres) son obligatorios.';
    } else {
        try {
            $pdo = new PDO(
                "mysql:host={$dbHost};charset=utf8mb4",
                $dbUser,
                $dbPass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");

            $schema = file_get_contents($root . '/sql/schema.sql');
            $schema = preg_replace('/CREATE DATABASE.*?;/s', '', $schema);
            $schema = preg_replace('/USE supervielle_personas;/', '', $schema);
            foreach (array_filter(array_map('trim', explode(';', $schema))) as $sql) {
                if ($sql !== '') {
                    $pdo->exec($sql);
                }
            }

            $hash = password_hash($adminPass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO administradores (usuario, password_hash, nombre) VALUES (?, ?, ?)');
            $stmt->execute([$adminUser, $hash, $adminNombre]);

            $config = require $sample;
            $config['db']['host'] = $dbHost;
            $config['db']['user'] = $dbUser;
            $config['db']['pass'] = $dbPass;
            $config['db']['name'] = $dbName;
            $config['discord']['enabled'] = $discordEnabled;
            $config['discord']['webhook_url'] = $discordUrl;

            file_put_contents($configPath, "<?php\nreturn " . var_export($config, true) . ";\n");
            $success = 'Instalación completada.';
            $done = true;
        } catch (Throwable $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instalación — Supervielle Personas</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-auth">
  <div class="admin-card">
    <h1>Instalación del panel</h1>
    <p class="muted">Crea la base de datos, el gerente y (opcional) el webhook de Discord.</p>

    <?php if ($error): ?><p class="alert alert-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="alert alert-success"><?= htmlspecialchars($success) ?></p><?php endif; ?>

    <?php if ($done && $success): ?>
      <p><a class="btn btn-primary" href="../admin/login.php">Ir al panel</a></p>
    <?php else: ?>
      <form method="post" class="admin-form">
        <h2>MySQL</h2>
        <label>Host<input name="db_host" value="127.0.0.1" required></label>
        <label>Usuario MySQL<input name="db_user" value="root" required></label>
        <label>Contraseña MySQL<input name="db_pass" type="password" placeholder="(vacío en WAMP)"></label>
        <label>Nombre BD<input name="db_name" value="supervielle_personas" required></label>

        <h2>Cuenta gerente</h2>
        <label>Nombre<input name="admin_nombre" value="Gerente" required></label>
        <label>Usuario<input name="admin_user" value="gerente" required></label>
        <label>Contraseña<input name="admin_pass" type="password" minlength="6" required></label>

        <h2>Discord (opcional)</h2>
        <label class="check"><input type="checkbox" name="discord_enabled" value="1"> Enviar avisos al canal Discord</label>
        <label>Webhook URL<input name="discord_webhook" placeholder="https://discord.com/api/webhooks/..."></label>

        <button type="submit" class="btn btn-primary">Instalar</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
