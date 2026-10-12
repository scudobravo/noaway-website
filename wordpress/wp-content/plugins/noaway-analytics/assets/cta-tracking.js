(function () {
  "use strict";

  var cfg = window.NoAwayAnalyticsCta || {};
  var STORAGE_KEY = cfg.storageKey || "noawayCtaAttribution";

  function analyticsAllowed() {
    try {
      if (window.NoAwayCookieConsent && typeof window.NoAwayCookieConsent.getState === "function") {
        var state = window.NoAwayCookieConsent.getState();
        return !!(state && state.analytics);
      }
      var key = cfg.cookieKey || "noawayCookieConsentV1";
      var raw = window.localStorage.getItem(key);
      if (!raw) return false;
      var parsed = JSON.parse(raw);
      return !!(parsed && parsed.analytics === true);
    } catch (err) {
      return false;
    }
  }

  function saveAttribution(payload) {
    try {
      window.localStorage.setItem(
        STORAGE_KEY,
        JSON.stringify({
          page_path: payload.page_path || "",
          page_slug: payload.page_slug || "",
          position: payload.position || "",
          ts: Date.now()
        })
      );
    } catch (err) {
      // ignore
    }
  }

  function readAttribution() {
    try {
      var raw = window.localStorage.getItem(STORAGE_KEY);
      if (!raw) return null;
      var parsed = JSON.parse(raw);
      if (!parsed || typeof parsed !== "object") return null;
      return parsed;
    } catch (err) {
      return null;
    }
  }

  function postEvent(body) {
    if (!cfg.restUrl) return Promise.resolve();
    if (!analyticsAllowed()) return Promise.resolve();
    return fetch(cfg.restUrl, {
      method: "POST",
      credentials: "same-origin",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        "X-WP-Nonce": cfg.nonce || ""
      },
      body: JSON.stringify(body),
      keepalive: true
    }).catch(function () {
      /* fire-and-forget */
    });
  }

  function trackClick(anchor) {
    var path = anchor.getAttribute("data-noaway-path") || window.location.pathname || "/";
    var position = anchor.getAttribute("data-noaway-position") || "cta";
    var slug = anchor.getAttribute("data-noaway-ref") || "";
    if (!slug) {
      var trim = String(path).replace(/^\/+|\/+$/g, "");
      slug = trim ? trim.split("/").pop() : "home";
    }
    var payload = {
      event_type: "click",
      page_path: path,
      page_slug: slug,
      position: position,
      session_id: ""
    };
    saveAttribution(payload);
    postEvent(payload);

    if (analyticsAllowed() && typeof window.gtag === "function") {
      window.gtag("event", "buy_cta_click", {
        page_path: path,
        page_slug: slug,
        button_position: position
      });
    }
  }

  function bindClicks() {
    document.addEventListener(
      "click",
      function (event) {
        var target = event.target;
        if (!(target instanceof Element)) return;
        var anchor = target.closest('a[data-noaway-cta="buy"]');
        if (!anchor) return;
        trackClick(anchor);
      },
      true
    );
  }

  function trackPurchaseIfThankYou() {
    if (!cfg.isThankYou) return;
    var sessionId = typeof cfg.sessionId === "string" ? cfg.sessionId : "";
    if (!sessionId || !/^cs_[a-zA-Z0-9]+$/.test(sessionId)) return;

    var attr = readAttribution() || {};
    var path = attr.page_path || "/";
    var slug = attr.page_slug || "unknown";
    var position = attr.position || "checkout";

    postEvent({
      event_type: "purchase",
      page_path: path,
      page_slug: slug,
      position: position,
      session_id: sessionId
    });

    if (analyticsAllowed() && typeof window.gtag === "function") {
      window.gtag("event", "purchase_attributed", {
        page_slug: slug,
        page_path: path
      });
    }
  }

  function init() {
    bindClicks();
    trackPurchaseIfThankYou();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init, { once: true });
  } else {
    init();
  }
})();
