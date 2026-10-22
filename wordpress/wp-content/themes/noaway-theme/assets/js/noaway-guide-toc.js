/**
 * Guide pages: highlight the TOC link of the section currently in view.
 */
(function () {
  "use strict";

  function init() {
    var nav = document.querySelector("[data-noaway-guide-toc]");
    if (!nav) return;

    var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
    var map = {};
    var targets = [];
    links.forEach(function (link) {
      var id = decodeURIComponent(link.getAttribute("href").slice(1));
      var el = document.getElementById(id);
      if (el) {
        map[id] = link;
        targets.push(el);
      }
    });
    if (!targets.length) return;

    function setActive(id) {
      links.forEach(function (link) {
        var on = map[id] === link;
        link.classList.toggle("is-active", on);
        if (on) {
          link.setAttribute("aria-current", "true");
        } else {
          link.removeAttribute("aria-current");
        }
      });
    }

    if (!("IntersectionObserver" in window)) {
      setActive(targets[0].id);
      return;
    }

    var visible = {};
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          visible[entry.target.id] = entry.isIntersecting;
        });
        for (var i = 0; i < targets.length; i++) {
          if (visible[targets[i].id]) {
            setActive(targets[i].id);
            return;
          }
        }
      },
      { rootMargin: "-15% 0px -70% 0px", threshold: 0 }
    );
    targets.forEach(function (el) {
      observer.observe(el);
    });
    setActive(targets[0].id);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
