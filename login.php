SUPERVIELLE PERSONAS — PAQUETE LISTO PARA CPANEL
================================================

Incluye:
- Portada + login + monitoreo
- Discord (panel /admin/discord.php + cacert SSL)
- Cookies + Términos
- Responsive móvil / PC


PASO 1 — Subir
--------------
1. cPanel → File Manager → carpeta del dominio
2. Subir: supervielle-personas-SUBIR-A-CPANEL.zip
3. Extract DENTRO de esa carpeta
4. Debe quedar: index.html directo (sin carpeta extra)


PASO 2 — Base de datos
----------------------
1. MySQL Databases → crear BD
2. Crear usuario MySQL
3. Add User To Database → ALL PRIVILEGES


PASO 3 — Instalar
-----------------
Abrir: https://tudominio.com/install/
Completar MySQL + gerente
(Discord se puede configurar después en el panel)


PASO 4 — Probar
---------------
Inicio:  https://tudominio.com/
Login:   https://tudominio.com/login.html
Panel:   https://tudominio.com/admin/login.php
Discord: https://tudominio.com/admin/discord.php
Terminos:https://tudominio.com/terminos.html
Cookies: https://tudominio.com/cookies-politica.html


PASO 5 — Discord
----------------
1. Entrar al panel
2. Botón Discord
3. Pegar webhook → Guardar → Enviar prueba


NOTA
----
No subas config/config.php de WAMP. Se crea en /install/
Si reinstalás, conservá tu config.php del hosting.
