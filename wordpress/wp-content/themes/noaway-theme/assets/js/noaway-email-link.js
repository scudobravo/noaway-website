(function () {
  "use strict";

  function analyticsAllowed() {
    try {
      if (window.NoAwayCookieConsent && typeof window.NoAwayCookieConsent.getState === "function") {
        var state = window.NoAwayCookieConsent.getState();
        return !!(state && state.analytics);
      }
      var cfg = window.NoAwayEmailLink || {};
      var key = cfg.cookieKey || "noawayCookieConsentV1";
      var raw = window.localStorage.getItem(key);
      if (!raw) return false;
      var parsed = JSON.parse(raw);
      return !!(parsed && parsed.analytics === true);
    } catch (err) {
      return false;
    }
  }

  function trackEvent(name, params) {
    if (!analyticsAllowed()) return;
    if (typeof window.gtag !== "function") return;
    window.gtag("event", name, params || {});
  }

  function initForm(root) {
    var form = root.querySelector("[data-noaway-email-link-form]");
    var statusEl = root.querySelector("[data-noaway-email-link-status]");
    if (!form) return;

    var toggle = root.querySelector("[data-noaway-email-link-toggle]");
    var panel = root.querySelector("[data-noaway-email-link-panel]");
    if (toggle && panel) {
      toggle.addEventListener("click", function () {
        var open = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", open ? "false" : "true");
        panel.hidden = open;
        if (!open) {
          var firstInput = panel.querySelector('input[name="email"]');
          if (firstInput) firstInput.focus();
        }
      });
    }

    var cfg = window.NoAwayEmailLink || {};
    var restUrl = cfg.restUrl || "";
    var nonce = cfg.nonce || "";
    var i18n = cfg.i18n || {};

    function setStatus(message, kind) {
      if (!statusEl) return;
      statusEl.hidden = !message;
      statusEl.textContent = message || "";
      statusEl.classList.remove("is-error", "is-success");
      if (kind === "error") statusEl.classList.add("is-error");
      if (kind === "success") statusEl.classList.add("is-success");
    }

    form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (!restUrl) {
        setStatus(i18n.error || "Something went wrong.", "error");
        return;
      }

      var emailInput = form.querySelector('input[name="email"]');
      var honeypot = form.querySelector('input[name="website"]');
      var marketing = form.querySelector('input[name="marketing_opt_in"]');
      var submitBtn = form.querySelector('button[type="submit"]');
      var email = emailInput ? String(emailInput.value || "").trim() : "";

      if (!email || email.indexOf("@") < 1) {
        setStatus(i18n.error || "Please enter a valid email.", "error");
        if (emailInput) emailInput.focus();
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.dataset.originalLabel = submitBtn.textContent;
        submitBtn.textContent = i18n.sending || "Sending…";
      }
      setStatus("", "");

      var body = {
        email: email,
        marketing_opt_in: !!(marketing && marketing.checked),
        website: honeypot ? String(honeypot.value || "") : "",
        page_url: window.location.href
      };

      fetch(restUrl, {
        method: "POST",
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-WP-Nonce": nonce
        },
        body: JSON.stringify(body)
      })
        .then(function (res) {
          return res.json().then(function (data) {
            return { ok: res.ok, status: res.status, data: data };
          });
        })
        .then(function (result) {
          if (result.ok && result.data && result.data.ok) {
            setStatus((result.data && result.data.message) || i18n.success || "Check your inbox.", "success");
            trackEvent("email_download_link", {
              marketing_opt_in: body.marketing_opt_in ? 1 : 0
            });
            form.reset();
            return;
          }
          var msg = i18n.error || "Something went wrong.";
          if (result.data) {
            if (typeof result.data.message === "string" && result.data.message) {
              msg = result.data.message;
            } else if (result.data.data && typeof result.data.data.message === "string") {
              msg = result.data.data.message;
            }
          }
          setStatus(msg, "error");
        })
        .catch(function () {
          setStatus(i18n.error || "Something went wrong.", "error");
        })
        .finally(function () {
          if (submitBtn) {
            submitBtn.disabled = false;
            if (submitBtn.dataset.originalLabel) {
              submitBtn.textContent = submitBtn.dataset.originalLabel;
            }
          }
        });
    });
  }

  function init() {
    var roots = document.querySelectorAll("[data-noaway-email-link]");
    if (!roots.length) return;
    Array.prototype.forEach.call(roots, initForm);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init, { once: true });
  } else {
    init();
  }
})();
