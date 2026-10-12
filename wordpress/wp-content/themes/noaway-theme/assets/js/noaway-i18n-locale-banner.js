/**
 * Non-redirecting locale suggestion on Slack/Teams guides.
 * Shows a banner when navigator.language matches de/es/fr/pt and a translated
 * version exists; dismiss state is stored in localStorage (try/catch).
 */
(function () {
  'use strict';

  var cfg = window.NoAwayI18nBanner;
  if (!cfg || !cfg.urls || !cfg.messages) {
    return;
  }

  var host = document.querySelector('[data-noaway-locale-banner]');
  if (!host) {
    return;
  }

  function detectSuggestedLang() {
    var raw = '';
    try {
      raw = String(navigator.language || navigator.userLanguage || '').toLowerCase();
    } catch (e) {
      raw = '';
    }
    if (!raw) {
      return '';
    }
    if (raw.indexOf('pt') === 0) {
      return 'pt-br';
    }
    if (raw.indexOf('de') === 0) {
      return 'de';
    }
    if (raw.indexOf('es') === 0) {
      return 'es';
    }
    if (raw.indexOf('fr') === 0) {
      return 'fr';
    }
    return '';
  }

  function storageKey(lang) {
    return String(cfg.storageKey || 'noaway.i18nBanner.dismissed.v1') +
      '.' + String(cfg.family || 'guide') +
      '.' + String(lang || '');
  }

  function isDismissed(lang) {
    try {
      return window.localStorage.getItem(storageKey(lang)) === '1';
    } catch (e) {
      return false;
    }
  }

  function dismiss(lang) {
    try {
      window.localStorage.setItem(storageKey(lang), '1');
    } catch (e) {
      /* ignore quota / private mode */
    }
    host.hidden = true;
    host.textContent = '';
  }

  var suggested = detectSuggestedLang();
  var current = String(cfg.currentLang || 'en');
  if (!suggested || suggested === current) {
    return;
  }
  if (!cfg.urls[suggested] || !cfg.messages[suggested]) {
    return;
  }
  if (isDismissed(suggested)) {
    return;
  }

  var dismissLabel = (cfg.dismissAria && cfg.dismissAria[current]) ||
    (cfg.dismissAria && cfg.dismissAria.en) ||
    'Dismiss';

  var inner = document.createElement('div');
  inner.className = 'noaway-locale-banner__inner';

  var link = document.createElement('a');
  link.className = 'noaway-locale-banner__link';
  link.href = cfg.urls[suggested];
  link.setAttribute('hreflang', suggested === 'pt-br' ? 'pt-BR' : suggested);
  link.textContent = cfg.messages[suggested];

  var btn = document.createElement('button');
  btn.type = 'button';
  btn.className = 'noaway-locale-banner__dismiss';
  btn.setAttribute('aria-label', dismissLabel);
  btn.textContent = '×';
  btn.addEventListener('click', function () {
    dismiss(suggested);
  });

  inner.appendChild(link);
  inner.appendChild(btn);
  host.appendChild(inner);
  host.hidden = false;
})();
