(function () {
  var bankingBtn = document.getElementById("btn-banking");
  var mobileBanking = document.getElementById("mobile-banking");
  var panel = document.getElementById("banking-panel");
  var backdrop = document.getElementById("banking-backdrop");
  var closeBtn = document.getElementById("banking-close");
  var menuToggle = document.getElementById("menu-toggle");
  var mobileNav = document.getElementById("mobile-nav");
  var personasCard = document.getElementById("card-personas");
  var navigating = false;

  function openBanking() {
    if (!panel || !backdrop) return;
    panel.hidden = false;
    backdrop.hidden = false;
    requestAnimationFrame(function () {
      panel.classList.add("is-open");
      backdrop.classList.add("is-open");
      document.body.classList.add("banking-open");
      if (bankingBtn) {
        bankingBtn.classList.add("is-active");
        bankingBtn.setAttribute("aria-expanded", "true");
      }
      panel.setAttribute("aria-hidden", "false");
    });
    if (mobileNav) mobileNav.classList.remove("is-open");
  }

  function closeBanking() {
    if (!panel || !backdrop) return;
    panel.classList.remove("is-open");
    backdrop.classList.remove("is-open");
    document.body.classList.remove("banking-open");
    if (bankingBtn) {
      bankingBtn.classList.remove("is-active");
      bankingBtn.setAttribute("aria-expanded", "false");
    }
    panel.setAttribute("aria-hidden", "true");
    setTimeout(function () {
      if (!panel.classList.contains("is-open")) {
        panel.hidden = true;
        backdrop.hidden = true;
      }
    }, 320);
  }

  function toggleBanking() {
    if (panel && panel.classList.contains("is-open")) closeBanking();
    else openBanking();
  }

  function goPersonasLogin(e) {
    if (e) {
      e.preventDefault();
      e.stopPropagation();
      if (typeof e.stopImmediatePropagation === "function") e.stopImmediatePropagation();
    }
    if (navigating) return;
    navigating = true;

    var href = "./login.html";
    if (personasCard) {
      href =
        personasCard.getAttribute("data-href") ||
        personasCard.getAttribute("href") ||
        "./login.html";
    }

    // Forzar navegación (móvil + PC)
    window.location.href = href;
  }

  if (bankingBtn) {
    bankingBtn.addEventListener("click", function (e) {
      e.stopPropagation();
      toggleBanking();
    });
  }

  if (mobileBanking) {
    mobileBanking.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      openBanking();
    });
  }

  if (closeBtn) closeBtn.addEventListener("click", closeBanking);
  if (backdrop) backdrop.addEventListener("click", closeBanking);

  // Personas: touchend + click para que el celular no “se coma” el tap
  if (personasCard) {
    personasCard.addEventListener("touchend", goPersonasLogin, { passive: false });
    personasCard.addEventListener("click", goPersonasLogin, { passive: false });
    personasCard.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") goPersonasLogin(e);
    });
  }

  // Delegación extra por si el tap cae en un hijo del card
  if (panel) {
    panel.addEventListener(
      "click",
      function (e) {
        var t = e.target;
        if (!t || !t.closest) return;
        var card = t.closest("#card-personas, .banking-card--personas");
        if (card) goPersonasLogin(e);
      },
      true
    );
  }

  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeBanking();
  });

  if (menuToggle && mobileNav) {
    menuToggle.addEventListener("click", function () {
      mobileNav.classList.toggle("is-open");
    });
  }
})();
