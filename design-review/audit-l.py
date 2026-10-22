#!/usr/bin/env python3
"""Prompt L: screenshots + a11y-ish audit against live sitemap (baseline pre-deploy)."""
from __future__ import annotations

import json
import os
import re
import sys
import urllib.parse
import urllib.request
import xml.etree.ElementTree as ET
from pathlib import Path

from playwright.sync_api import sync_playwright

ROOT = Path(__file__).resolve().parent
SCREENS = ROOT / "screens"
AFTER = ROOT / "after"
REPORTS = ROOT / "reports"
WIDTHS = (390, 768, 1024, 1440)
SITEMAP = "https://noaway.app/sitemap.xml"
# Cap pages so the run finishes in reasonable time; prioritize key templates.
PRIORITY = [
    "/",
    "/features/",
    "/how-it-works/",
    "/keep-teams-active/",
    "/keep-slack-active/",
    "/teams-away-status/",
    "/prevent-computer-sleep/",
    "/is-noaway-safe/",
    "/downloads/",
    "/faq/",
    "/help/",
    "/compare/",
    "/sitemap/",
    "/privacy-policy/",
    "/terms-of-service/",
    "/contatti/",
]


def fetch_urls() -> list[str]:
    req = urllib.request.Request(SITEMAP, headers={"User-Agent": "NoAway-DesignReview/1.0"})
    with urllib.request.urlopen(req, timeout=30) as resp:
        data = resp.read()
    root = ET.fromstring(data)
    ns = {"sm": "http://www.sitemaps.org/schemas/sitemap/0.9"}
    locs = [el.text.strip() for el in root.findall(".//sm:loc", ns) if el.text]
    if not locs:
        locs = [el.text.strip() for el in root.findall(".//{*}loc") if el.text]
    # Prefer priority paths first, then rest (deduped).
    ordered: list[str] = []
    seen = set()
    for path in PRIORITY:
        for u in locs:
            if u.rstrip("/").endswith(path.rstrip("/")) or (path == "/" and u.rstrip("/").endswith("noaway.app")):
                if u not in seen:
                    ordered.append(u)
                    seen.add(u)
                break
    for u in locs:
        if u not in seen:
            ordered.append(u)
            seen.add(u)
    return ordered


def slug(url: str) -> str:
    path = urllib.parse.urlparse(url).path.strip("/") or "home"
    return re.sub(r"[^a-zA-Z0-9._-]+", "-", path)[:80]


def contrast_ratio(fg: tuple[int, int, int], bg: tuple[int, int, int]) -> float:
    def lin(c: int) -> float:
        x = c / 255.0
        return x / 12.92 if x <= 0.04045 else ((x + 0.055) / 1.055) ** 2.4

    def lum(rgb: tuple[int, int, int]) -> float:
        r, g, b = rgb
        return 0.2126 * lin(r) + 0.7152 * lin(g) + 0.0722 * lin(b)

    l1, l2 = lum(fg), lum(bg)
    lighter, darker = max(l1, l2), min(l1, l2)
    return (lighter + 0.05) / (darker + 0.05)


def parse_rgb(s: str) -> tuple[int, int, int] | None:
    if not s:
        return None
    m = re.search(r"rgba?\((\d+),\s*(\d+),\s*(\d+)", s)
    if not m:
        return None
    return int(m.group(1)), int(m.group(2)), int(m.group(3))


def audit_page(page, url: str, width: int) -> dict:
    page.set_viewport_size({"width": width, "height": 900})
    page.goto(url, wait_until="domcontentloaded", timeout=60000)
    page.wait_for_timeout(800)
    # Dismiss cookie banner if present so layout is measurable.
    for sel in [
        "[data-consent-accept]",
        ".noaway-cc-btn--primary",
        "button:has-text('Accept')",
        "button:has-text('Reject')",
    ]:
        try:
            btn = page.locator(sel).first
            if btn.count() and btn.is_visible():
                btn.click(timeout=1500)
                page.wait_for_timeout(300)
                break
        except Exception:
            pass

    metrics = page.evaluate(
        """() => {
      const doc = document.documentElement;
      const body = document.body;
      const overflowX = Math.max(doc.scrollWidth, body.scrollWidth) - window.innerWidth;
      const imgs = [...document.images].map(img => ({
        src: img.currentSrc || img.src,
        w: img.getAttribute('width'),
        h: img.getAttribute('height'),
        naturalW: img.naturalWidth,
        naturalH: img.naturalHeight,
        hasAspect: !!(img.style.aspectRatio || getComputedStyle(img).aspectRatio !== 'auto'
          || (img.parentElement && getComputedStyle(img.parentElement).aspectRatio !== 'auto')),
      }));
      const interactive = [...document.querySelectorAll('a, button, summary, input, select, textarea')]
        .filter(el => {
          const st = getComputedStyle(el);
          return st.display !== 'none' && st.visibility !== 'hidden' && el.offsetParent !== null;
        })
        .map(el => {
          const r = el.getBoundingClientRect();
          const st = getComputedStyle(el);
          return {
            tag: el.tagName.toLowerCase(),
            text: (el.innerText || el.getAttribute('aria-label') || '').trim().slice(0, 60),
            h: Math.round(r.height),
            w: Math.round(r.width),
            outline: st.outlineStyle,
            outlineWidth: st.outlineWidth,
          };
        });
      // Sample text nodes for contrast (first 40 visible text-ish elements).
      const textEls = [...document.querySelectorAll('p, h1, h2, h3, h4, li, a, span, button, td, th, label')]
        .filter(el => {
          const t = (el.innerText || '').trim();
          if (t.length < 2 || t.length > 200) return false;
          const r = el.getBoundingClientRect();
          return r.width > 0 && r.height > 0;
        })
        .slice(0, 50)
        .map(el => {
          const st = getComputedStyle(el);
          let bg = st.backgroundColor;
          let node = el;
          while (node && (bg === 'rgba(0, 0, 0, 0)' || bg === 'transparent')) {
            node = node.parentElement;
            if (!node) break;
            bg = getComputedStyle(node).backgroundColor;
          }
          return {
            text: (el.innerText || '').trim().slice(0, 40),
            color: st.color,
            bg,
            fontSize: parseFloat(st.fontSize) || 0,
          };
        });
      return {
        overflowX,
        scrollHeight: Math.max(doc.scrollHeight, body.scrollHeight),
        imgs,
        interactive,
        textEls,
        innerText: (body.innerText || '').replace(/\\s+/g, ' ').trim(),
      };
    }"""
    )

    low_contrast = []
    for t in metrics["textEls"]:
        fg = parse_rgb(t["color"])
        bg = parse_rgb(t["bg"])
        if not fg or not bg:
            continue
        ratio = contrast_ratio(fg, bg)
        large = t["fontSize"] >= 18 or (t["fontSize"] >= 14 and False)  # bold large not tracked
        min_ratio = 3.0 if t["fontSize"] >= 24 else 4.5
        if ratio < min_ratio:
            low_contrast.append(
                {
                    "text": t["text"],
                    "ratio": round(ratio, 2),
                    "color": t["color"],
                    "bg": t["bg"],
                    "fontSize": t["fontSize"],
                }
            )

    small_touch = []
    if width <= 390:
        for el in metrics["interactive"]:
            if el["h"] < 44 and el["w"] < 44:
                small_touch.append(el)
            elif el["h"] < 44 and el["tag"] in ("a", "button", "summary"):
                # Isolated links under buttons etc.
                small_touch.append(el)

    imgs_missing = [
        i
        for i in metrics["imgs"]
        if (not i["w"] or not i["h"]) and not i["hasAspect"]
    ]

    return {
        "url": url,
        "width": width,
        "overflowX": metrics["overflowX"],
        "scrollHeight": metrics["scrollHeight"],
        "imgsMissingDims": len(imgs_missing),
        "imgsMissingSample": imgs_missing[:5],
        "lowContrast": low_contrast[:15],
        "smallTouch": small_touch[:20],
        "innerText": metrics["innerText"],
    }


def main() -> int:
    SCREENS.mkdir(parents=True, exist_ok=True)
    AFTER.mkdir(parents=True, exist_ok=True)
    REPORTS.mkdir(parents=True, exist_ok=True)

    urls = fetch_urls()
    # Limit to priority + a few more for runtime.
    urls = urls[:22]
    print(f"Auditing {len(urls)} URLs x {len(WIDTHS)} widths", flush=True)

    reports = []
    texts = {}

    with sync_playwright() as p:
        browser = p.chromium.launch(headless=True)
        context = browser.new_context()
        page = context.new_page()
        for url in urls:
            s = slug(url)
            print(f"→ {url}", flush=True)
            for w in WIDTHS:
                try:
                    result = audit_page(page, url, w)
                    # Full-page screenshot into screens (live baseline) and after/ placeholder note.
                    out = SCREENS / f"{s}-{w}.png"
                    page.screenshot(path=str(out), full_page=True)
                    # Mirror path for after/ once deploy happens; for now copy baseline label.
                    after_out = AFTER / f"{s}-{w}.png"
                    if not after_out.exists():
                        # Symlink-like: keep a note file; actual after shots need local/post-deploy.
                        pass
                    reports.append({k: v for k, v in result.items() if k != "innerText"})
                    if w == 1440:
                        texts[url] = result["innerText"]
                    print(
                        f"  {w}px overflowX={result['overflowX']} "
                        f"contrastIssues={len(result['lowContrast'])} "
                        f"smallTouch={len(result['smallTouch'])} "
                        f"imgsNoDim={result['imgsMissingDims']} h={result['scrollHeight']}",
                        flush=True,
                    )
                except Exception as e:
                    print(f"  FAIL {w}: {e}", flush=True)
                    reports.append({"url": url, "width": w, "error": str(e)})
        browser.close()

    summary = {
        "note": (
            "Screenshots in design-review/screens/ are LIVE (pre-deploy) baseline. "
            "Theme changes are local-only until deploy; re-run into design-review/after/ after deploy or against local WP."
        ),
        "pages": len(urls),
        "overflow": [r for r in reports if r.get("overflowX", 0) > 1],
        "homeHeight390": next(
            (r["scrollHeight"] for r in reports if r.get("width") == 390 and r.get("url", "").rstrip("/").endswith("noaway.app")),
            None,
        ),
        "reports": reports,
    }
    (REPORTS / "audit-live.json").write_text(json.dumps(summary, indent=2), encoding="utf-8")
    (REPORTS / "innertext-live.json").write_text(json.dumps(texts, indent=2), encoding="utf-8")

    # Markdown summary
    lines = [
        "# Prompt L — audit live (pre-deploy baseline)",
        "",
        summary["note"],
        "",
        f"- URL controllate: {len(urls)}",
        f"- Overflow-x > 1px: {len(summary['overflow'])}",
        f"- Altezza home @390 (live): {summary['homeHeight390']}",
        "",
        "## Overflow",
    ]
    if not summary["overflow"]:
        lines.append("Nessuno.")
    else:
        for r in summary["overflow"][:30]:
            lines.append(f"- {r['url']} @{r['width']}: {r['overflowX']}px")

    lines += ["", "## Contrast < 4.5 (campione live)"]
    ccount = 0
    for r in reports:
        for c in r.get("lowContrast") or []:
            ccount += 1
            if ccount <= 25:
                lines.append(
                    f"- {r['url']} @{r['width']}: “{c['text']}” ratio {c['ratio']}:1"
                )
    if ccount == 0:
        lines.append("Nessuno nel campione.")
    else:
        lines.append(f"\nTotale segnalazioni campione: {ccount}")

    lines += ["", "## Touch < 44px @390"]
    tcount = 0
    for r in reports:
        if r.get("width") != 390:
            continue
        for t in r.get("smallTouch") or []:
            tcount += 1
            if tcount <= 25:
                lines.append(f"- {r['url']}: <{t['tag']}> h={t['h']} “{t['text']}”")
    if tcount == 0:
        lines.append("Nessuno nel campione.")
    else:
        lines.append(f"\nTotale: {tcount}")

    (REPORTS / "AUDIT_L.md").write_text("\n".join(lines) + "\n", encoding="utf-8")
    print("Wrote", REPORTS / "AUDIT_L.md", flush=True)
    return 0


if __name__ == "__main__":
    sys.exit(main())
