/**
 * Mobile sticky Buy bar.
 * Visible once the hero buy button has scrolled out of view; hidden again while the
 * final CTA is on screen or while the cookie banner/modal is open.
 */
(function () {
  "use strict";

  function init() {
    var bar = document.querySelector("[data-noaway-sticky-buy]");
    if (!bar) return;

    var heroTarget =
      document.querySelector('[data-noaway-cta="buy"][data-noaway-position="hero"]') ||
      document.querySelector("[data-noaway-sticky-after]");
    var finalCta = document.querySelector("[data-noaway-final-cta]");
    var cookieBanner = document.querySelector("[data-consent-banner]");
    var cookieModal = document.querySelector("[data-consent-modal]");

    var heroGone = false;
    var finalVisible = false;
    var cookieOpen = false;

    function update() {
      var show = heroGone && !finalVisible && !cookieOpen;
      bar.classList.toggle("is-visible", show);
      bar.setAttribute("aria-hidden", show ? "false" : "true");
    }

    function readCookieState() {
      cookieOpen =
        (!!cookieBanner && !cookieBanner.hasAttribute("hidden")) ||
        (!!cookieModal && !cookieModal.hasAttribute("hidden"));
    }

    // Hero: "gone" only when it scrolled above the viewport (not when still below).
    if (heroTarget && "IntersectionObserver" in window) {
      new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            heroGone = !entry.isIntersecting && entry.boundingClientRect.top < 0;
          });
          update();
        },
        { threshold: 0 }
      ).observe(heroTarget);
    } else {
      var onScroll = function () {
        var limit = heroTarget ? heroTarget.getBoundingClientRect().bottom + window.scrollY : 480;
        heroGone = window.scrollY > limit;
        update();
      };
      window.addEventListener("scroll", onScroll, { passive: true });
      onScroll();
    }

    if (finalCta && "IntersectionObserver" in window) {
      new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            finalVisible = entry.isIntersecting;
          });
          update();
        },
        { threshold: 0 }
      ).observe(finalCta);
    }

    if ("MutationObserver" in window) {
      var mo = new MutationObserver(function () {
        readCookieState();
        update();
      });
      [cookieBanner, cookieModal].forEach(function (node) {
        if (node) mo.observe(node, { attributes: true, attributeFilter: ["hidden", "class", "style"] });
      });
    }
    readCookieState();
    update();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
