(function () {
  'use strict';

  var COOKIE_KEY = 'agrosol_cookie_consent';
  var header = document.querySelector('.site-header');
  var navToggle = document.querySelector('[data-nav-toggle]');
  var navMobile = document.querySelector('[data-nav-mobile]');
  var navClose = document.querySelector('[data-nav-close]');
  var navLinks = document.querySelectorAll('[data-nav-link]');
  var contactForm = document.querySelector('[data-contact-form]');
  var formSuccess = document.querySelector('[data-form-success]');
  var yearEl = document.querySelector('[data-year]');

  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }

  function onScroll() {
    if (!header) return;
    header.classList.toggle('scrolled', window.scrollY > 8);
  }

  function openNav() {
    if (!navMobile) return;
    navMobile.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeNav() {
    if (!navMobile) return;
    navMobile.classList.remove('open');
    document.body.style.overflow = '';
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (navToggle) navToggle.addEventListener('click', openNav);
  if (navClose) navClose.addEventListener('click', closeNav);
  if (navMobile) {
    navMobile.addEventListener('click', function (e) {
      if (e.target === navMobile) closeNav();
    });
  }

  navLinks.forEach(function (link) {
    link.addEventListener('click', closeNav);
  });

  /* ─── Cookie consent (Google Ads compliance) ─── */
  var cookieBanner = document.querySelector('[data-cookie-banner]');
  var cookieModal = document.querySelector('[data-cookie-modal]');
  var cookieAnalytics = document.querySelector('[data-cookie-analytics]');
  var cookieMarketing = document.querySelector('[data-cookie-marketing]');
  var cookieSettingsBtns = document.querySelectorAll('[data-cookie-settings]');

  function getConsent() {
    try {
      return JSON.parse(localStorage.getItem(COOKIE_KEY));
    } catch (e) {
      return null;
    }
  }

  function saveConsent(consent) {
    localStorage.setItem(COOKIE_KEY, JSON.stringify(consent));
    applyConsent(consent);
    if (cookieBanner) cookieBanner.hidden = true;
    if (cookieModal) {
      cookieModal.hidden = true;
      cookieModal.setAttribute('aria-hidden', 'true');
    }
  }

  function applyConsent(consent) {
    if (!consent) return;
    /* Inserte aquí Google Tag / gtag solo cuando consent.marketing o consent.analytics sea true */
    if (consent.analytics || consent.marketing) {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({ event: 'cookie_consent_granted', analytics: !!consent.analytics, marketing: !!consent.marketing });
    }
  }

  function showCookieBanner() {
    if (cookieBanner) cookieBanner.hidden = false;
  }

  function openCookieModal() {
    if (!cookieModal) return;
    var consent = getConsent();
    if (cookieAnalytics) cookieAnalytics.checked = consent ? !!consent.analytics : false;
    if (cookieMarketing) cookieMarketing.checked = consent ? !!consent.marketing : false;
    cookieModal.hidden = false;
    cookieModal.setAttribute('aria-hidden', 'false');
  }

  function closeCookieModal() {
    if (!cookieModal) return;
    cookieModal.hidden = true;
    cookieModal.setAttribute('aria-hidden', 'true');
  }

  var existingConsent = getConsent();
  if (existingConsent) {
    applyConsent(existingConsent);
  } else {
    showCookieBanner();
  }

  var acceptAllBtn = document.querySelector('[data-cookie-accept-all]');
  var essentialBtn = document.querySelector('[data-cookie-essential]');
  var saveCookieBtn = document.querySelector('[data-cookie-save]');

  if (acceptAllBtn) {
    acceptAllBtn.addEventListener('click', function () {
      saveConsent({ essential: true, analytics: true, marketing: true, date: new Date().toISOString() });
    });
  }

  if (essentialBtn) {
    essentialBtn.addEventListener('click', function () {
      saveConsent({ essential: true, analytics: false, marketing: false, date: new Date().toISOString() });
    });
  }

  if (saveCookieBtn) {
    saveCookieBtn.addEventListener('click', function () {
      saveConsent({
        essential: true,
        analytics: cookieAnalytics ? cookieAnalytics.checked : false,
        marketing: cookieMarketing ? cookieMarketing.checked : false,
        date: new Date().toISOString()
      });
    });
  }

  cookieSettingsBtns.forEach(function (btn) {
    btn.addEventListener('click', openCookieModal);
  });

  document.querySelectorAll('[data-cookie-modal-close]').forEach(function (el) {
    el.addEventListener('click', closeCookieModal);
  });

  /* ─── Video modal ─── */
  var videoModal = document.querySelector('[data-video-modal]');
  var videoOpen = document.querySelectorAll('[data-video-open]');
  var videoCloseEls = document.querySelectorAll('[data-video-close]');
  var videoIframe = document.querySelector('[data-video-iframe]');
  var videoFrame = document.querySelector('.video-modal-frame');
  /* Video: perforación de pozo en finca agrícola (reemplace con su video propio si lo tiene) */
  var videoUrl = 'https://www.youtube-nocookie.com/embed/61ozVUURenE?autoplay=1&rel=0&modestbranding=1';

  function openVideo() {
    if (!videoModal) return;
    if (videoIframe && videoUrl) {
      videoIframe.src = videoUrl;
      if (videoFrame) videoFrame.classList.add('has-video');
    }
    videoModal.hidden = false;
    videoModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closeVideo() {
    if (!videoModal) return;
    videoModal.hidden = true;
    videoModal.setAttribute('aria-hidden', 'true');
    if (videoIframe) videoIframe.src = '';
    if (videoFrame) videoFrame.classList.remove('has-video');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      closeNav();
      closeVideo();
      closeCookieModal();
    }
  });

  if (videoOpen.length) {
    videoOpen.forEach(function (btn) {
      btn.addEventListener('click', openVideo);
    });
  }
  videoCloseEls.forEach(function (el) {
    el.addEventListener('click', closeVideo);
  });

  /* ─── Forms ─── */
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var privacyCheck = contactForm.querySelector('#privacidad');
      if (privacyCheck && !privacyCheck.checked) return;
      if (formSuccess) {
        formSuccess.classList.add('show');
        contactForm.reset();
        setTimeout(function () {
          formSuccess.classList.remove('show');
        }, 5000);
      }
    });
  }

  var newsletterForm = document.querySelector('[data-newsletter-form]');
  var newsletterMsg = document.querySelector('[data-newsletter-msg]');

  if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (newsletterMsg) {
        newsletterMsg.hidden = false;
        newsletterForm.reset();
        setTimeout(function () {
          newsletterMsg.hidden = true;
        }, 4000);
      }
    });
  }

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    },
    { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
  );

  document.querySelectorAll('.service-card, .unique-card, .timeline-item, .about-feature').forEach(function (el) {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(el);
  });

  var style = document.createElement('style');
  style.textContent = '.visible { opacity: 1 !important; transform: translateY(0) !important; }';
  document.head.appendChild(style);
})();
