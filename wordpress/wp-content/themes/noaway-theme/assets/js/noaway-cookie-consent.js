(function () {
  "use strict";

  function initCookieConsent() {
    var config = window.NoAwayCookieConsentConfig || {};
    var storageKey = typeof config.storageKey === "string" && config.storageKey ? config.storageKey : "noawayCookieConsentV1";
    var gaMeasurementId = typeof config.gaMeasurementId === "string" ? config.gaMeasurementId.trim() : "";
    var privacyPolicyUrl = typeof config.privacyPolicyUrl === "string" && config.privacyPolicyUrl ? config.privacyPolicyUrl : "/privacy-policy";

    var state = null;
    var gaLoaded = false;
    var previousActiveElement = null;

    var root = document.querySelector("[data-noaway-cookie-consent]");
    if (!root) return;

    var banner = root.querySelector("[data-consent-banner]");
    var modalOverlay = root.querySelector("[data-consent-modal]");
    var analyticsCheckbox = root.querySelector("[data-consent-analytics]");
    var policyLink = root.querySelector(".noaway-cookie-consent__policy a");
    if (policyLink) policyLink.setAttribute("href", privacyPolicyUrl);

    function getDefaultState() {
      return {
        necessary: true,
        analytics: false,
        consentGiven: false,
        consentTimestamp: null
      };
    }

    function isValidState(input) {
      return (
        !!input &&
        input.necessary === true &&
        typeof input.analytics === "boolean" &&
        typeof input.consentGiven === "boolean" &&
        (typeof input.consentTimestamp === "string" || input.consentTimestamp === null)
      );
    }

    function readState() {
    try {
      var raw = window.localStorage.getItem(storageKey);
      if (!raw) return getDefaultState();
      var parsed = JSON.parse(raw);
      if (isValidState(parsed)) return parsed;
      return getDefaultState();
    } catch (err) {
      return getDefaultState();
    }
    }

    function persistState(nextState) {
    state = {
      necessary: true,
      analytics: !!nextState.analytics,
      consentGiven: !!nextState.consentGiven,
      consentTimestamp: nextState.consentTimestamp || new Date().toISOString()
    };
    try {
      window.localStorage.setItem(storageKey, JSON.stringify(state));
    } catch (err) {
      // No-op: if storage fails, consent state remains in memory for current page.
    }
    }

    function updateConsentMode(analyticsEnabled) {
    if (typeof window.gtag !== "function") return;
    window.gtag("consent", "update", {
      ad_storage: "denied",
      ad_user_data: "denied",
      ad_personalization: "denied",
      analytics_storage: analyticsEnabled ? "granted" : "denied"
    });
    }

    function loadGoogleAnalyticsIfNeeded() {
    if (!state || !state.analytics || gaLoaded) return;
    if (!/^G-[A-Z0-9]+$/i.test(gaMeasurementId)) return;

    gaLoaded = true;
    var script = document.createElement("script");
    script.async = true;
    script.src = "https://www.googletagmanager.com/gtag/js?id=" + encodeURIComponent(gaMeasurementId);
    script.onload = function () {
      if (typeof window.gtag === "function") {
        window.gtag("js", new Date());
        window.gtag("config", gaMeasurementId, {
          anonymize_ip: true
        });
      }
    };
    document.head.appendChild(script);
    }

    function hideBanner() {
    if (!banner) return;
    banner.setAttribute("hidden", "hidden");
    }

    function showBanner() {
    if (!banner) return;
    banner.removeAttribute("hidden");
    }

    function getFocusableElements() {
    if (!modalOverlay) return [];
    return Array.prototype.slice.call(
      modalOverlay.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
      )
    ).filter(function (el) {
      return !el.hasAttribute("disabled") && !el.getAttribute("aria-hidden");
    });
    }

    function closePreferences() {
    if (!modalOverlay) return;
    modalOverlay.setAttribute("hidden", "hidden");
    document.body.classList.remove("noaway-cookie-modal-open");
    if (previousActiveElement && typeof previousActiveElement.focus === "function") {
      previousActiveElement.focus();
    }
    }

    function openPreferences() {
    if (!modalOverlay) return;
    previousActiveElement = document.activeElement;
    if (analyticsCheckbox && state) analyticsCheckbox.checked = !!state.analytics;
    modalOverlay.removeAttribute("hidden");
    document.body.classList.add("noaway-cookie-modal-open");
    var focusables = getFocusableElements();
    if (focusables.length) focusables[0].focus();
    }

    function applyState(nextState) {
    persistState(nextState);
    updateConsentMode(state.analytics);
    if (state.analytics) loadGoogleAnalyticsIfNeeded();
    hideBanner();
    closePreferences();
    }

    function rejectOptionalCookies() {
    applyState({
      analytics: false,
      consentGiven: true,
      consentTimestamp: new Date().toISOString()
    });
    }

    function acceptAllCookies() {
    applyState({
      analytics: true,
      consentGiven: true,
      consentTimestamp: new Date().toISOString()
    });
    }

    function savePreferences() {
    applyState({
      analytics: !!(analyticsCheckbox && analyticsCheckbox.checked),
      consentGiven: true,
      consentTimestamp: new Date().toISOString()
    });
    }

    function handleAction(action) {
    if (action === "accept-all") acceptAllCookies();
    if (action === "reject-all") rejectOptionalCookies();
    if (action === "open-preferences") openPreferences();
    if (action === "close-preferences") closePreferences();
    if (action === "save-preferences") savePreferences();
    if (action === "reject-optional") rejectOptionalCookies();
    }

    root.addEventListener("click", function (event) {
    var target = event.target;
    if (!(target instanceof Element)) return;

    var actionTrigger = target.closest("[data-consent-action]");
    if (actionTrigger) {
      event.preventDefault();
      handleAction(actionTrigger.getAttribute("data-consent-action"));
    }
    });

    document.addEventListener("click", function (event) {
    var target = event.target;
    if (!(target instanceof Element)) return;
    var globalTrigger = target.closest("[data-cookie-settings]");
    if (!globalTrigger) return;
    event.preventDefault();
    openPreferences();
    });

    document.addEventListener("keydown", function (event) {
    if (!modalOverlay || modalOverlay.hasAttribute("hidden")) return;

    if (event.key === "Escape") {
      event.preventDefault();
      closePreferences();
      return;
    }

    if (event.key !== "Tab") return;
    var focusables = getFocusableElements();
    if (!focusables.length) return;

    var first = focusables[0];
    var last = focusables[focusables.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
    });

    if (modalOverlay) {
      modalOverlay.addEventListener("click", function (event) {
        if (event.target === modalOverlay) closePreferences();
      });
    }

    state = readState();
    updateConsentMode(!!state.analytics);
    if (state.consentGiven) {
      hideBanner();
      if (state.analytics) loadGoogleAnalyticsIfNeeded();
    } else {
      showBanner();
    }

    window.NoAwayCookieConsent = {
      openPreferences: openPreferences,
      revokeConsent: function () {
        rejectOptionalCookies();
        showBanner();
      },
      getState: function () {
        return state ? Object.assign({}, state) : getDefaultState();
      }
    };
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCookieConsent, { once: true });
  } else {
    initCookieConsent();
  }
})();
