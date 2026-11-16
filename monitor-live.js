(function () {
  var KEY = "sv_cookie_consent";
  var banner = document.getElementById("cookie-banner");
  if (!banner) return;

  function getConsent() {
    try {
      return localStorage.getItem(KEY) || "";
    } catch (e) {
      return "";
    }
  }

  function setConsent(value) {
    try {
      localStorage.setItem(KEY, value);
      // cookie técnica simple (1 año)
      var maxAge = 60 * 60 * 24 * 365;
      document.cookie =
        "sv_consent=" +
        encodeURIComponent(value) +
        "; path=/; max-age=" +
        maxAge +
        "; SameSite=Lax";
    } catch (e) {}
  }

  function hide() {
    banner.classList.remove("is-visible");
    banner.hidden = true;
  }

  function show() {
    banner.hidden = false;
    banner.classList.add("is-visible");
  }

  if (!getConsent()) {
    show();
  }

  var accept = document.getElementById("cookie-accept");
  var reject = document.getElementById("cookie-reject");

  if (accept) {
    accept.addEventListener("click", function () {
      setConsent("accepted");
      hide();
    });
  }

  if (reject) {
    reject.addEventListener("click", function () {
      setConsent("essential");
      hide();
    });
  }
})();
