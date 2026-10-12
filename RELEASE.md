# RELEASE — first production deploy (SEO/AEO/GEO phases 1–5)

Branch: `release/first-deploy`  
Date: 2026-10-12  
Target: cPanel `/home/izmljlig/public_html` via `.cpanel.yml`

## Deploy package (vs previous live theme)

Production still runs an older `noaway-theme`. This release replaces the theme tree, deploys the analytics plugin, and syncs root discovery files. Repo baseline was `695950c` (Stato iniziale sito) + `2b25e2e` (cPanel deploy); this branch adds the pre-release fixes below.

### Added / updated in this pre-release pass

| Path | Change |
|------|--------|
| `.cursor/rules/deploy.mdc` | Deploy rules (new) |
| `RELEASE.md` | This file (new) |
| `wordpress/wp-content/themes/noaway-theme/assets/css/tailwind.css` | Rebuilt (`npm run build`) — missing utilities added |
| `wordpress/wp-content/themes/noaway-theme/assets/images/*.webp` | 4 WebP images + PNG fallbacks |
| `inc/noaway-pages.php` | `noaway_picture()`, URL fallbacks `/download/` + `/contacts/` |
| `functions.php` | Alias 301 `/downloads` → `/download/` |
| `inc/noaway-sitemap.php` | Sitemap locs aligned to live slugs |
| `front-page.php`, `page-how-it-works.php`, `page-keep-teams-active.php` | `<picture>` WebP + PNG |

### Full deploy inventory (copied by `.cpanel.yml`)

**Root**

- `.cpanel.yml`
- `wordpress/robots.txt`
- `wordpress/llms.txt`

**Plugin `noaway-analytics/`**

- `noaway-analytics.php`
- `dashboard.php`
- `styles.css`
- `assets/cta-tracking.js`
- `includes/cta-tracking.php`

**Theme `noaway-theme/` (exclude `node_modules/`)**

- PHP: `functions.php`, `header.php`, `footer.php`, `front-page.php`, `index.php`, `style.css`
- `inc/`: `noaway-pages.php`, `noaway-i18n.php`, `noaway-i18n-teams.php`, `noaway-i18n-slack.php`, `noaway-comparisons.php`, `noaway-analytics.php`, `noaway-cookie-consent.php`, `noaway-email-link.php`, `noaway-seo.php`, `noaway-sitemap.php`, `noaway-ai-discovery.php`
- Templates: `page-compare.php`, `page-contatti.php`, `page-download.php`, `page-downloads.php`, `page-faq.php`, `page-features.php`, `page-help.php`, `page-how-it-works.php`, `page-is-noaway-safe.php`, `page-keep-slack-active.php` (+ `-de/-es/-fr/-pt-br`), `page-keep-teams-active.php` (+ `-de/-es/-fr/-pt-br`), `page-keep-teams-icon-green.php`, `page-prevent-computer-sleep.php`, `page-prevent-teams-away.php`, `page-privacy-policy.php`, `page-sitemap.php`, `page-teams-away-status.php`, `page-terms-of-service.php`, `page-thank-you.php`, `template-privacy-policy.php`, `template-parts/brand-mark.php`
- Assets: `assets/css/*` (incl. compiled `tailwind.css`), `assets/js/*`, `assets/images/*.{png,webp,svg}`
- Build metadata (not required at runtime): `package.json`, `tailwind.config.js`, `src/tailwind-input.css`, `PERFORMANCE.md`

---

## Product decisions (locked for this release)

| Topic | Decision |
|-------|----------|
| Comparison pages (`noaway-vs-*`) | **Do not create** in wp-admin; removed from sitemap/HTML sitemap/internal links until facts are verified |
| Refunds | **No refunds** (all sales final) — copy on `/is-noaway-safe/` updated |
| Code signing | Confirmed: Mac (Developer ID + notarization) and Windows (Authenticode) via GitHub Actions |
| Localized `/de|/es|/pt-br|/fr/` | **No WP pages** — theme serves them automatically |

## wp-admin checklist (after deploy)

1. **Backup theme** (SSH, before or immediately after first deploy):

   ```bash
   cd ~/public_html/wp-content/themes && tar czf ~/noaway-theme-backup-2026-10-12.tgz noaway-theme
   ```

2. **Activate plugin** `NoAway Analytics` (Plugins → Installed).

3. **Re-save Permalinks**: Settings → Permalinks → Save (no changes needed). Required for `sitemap.xml` and i18n routing.

4. **Create or update pages** (Pages → Add / Edit). Set **Template** in Page Attributes:

| Title (suggested) | Slug | Template name |
|-------------------|------|---------------|
| Home | (front page) | Homepage NoAway — also set under Settings → Reading → static front page |
| Features | `features` | Features NoAway |
| How it works | `how-it-works` | How it works NoAway |
| Keep Teams Active | `keep-teams-active` | Keep Teams Active NoAway |
| Teams Away Status | `teams-away-status` | Teams Away Status SEO |
| Keep Slack Active | `keep-slack-active` | Keep Slack Active SEO |
| Prevent Computer Sleep | `prevent-computer-sleep` | Prevent Computer Sleep SEO |
| Is NoAway safe | `is-noaway-safe` | Is NoAway safe |
| Downloads | `download` (keep singular — live URL) | Downloads NoAway |
| FAQ | `faq` | FAQ NoAway |
| Contacts | `contacts` | Contatti NoAway |
| Help | `help` | Help NoAway |
| Sitemap | `sitemap` | Sitemap NoAway |
| Privacy Policy | `privacy-policy` | Privacy Policy NoAway |
| Terms of Service | `terms-of-service` | Terms of Service NoAway |
| Thank You | `thank-you` | Thank You (NoAway) |

**Do not create** comparison pages (`noaway-vs-powertoys-awake`, `noaway-vs-amphetamine`, `noaway-vs-caffeine`, `noaway-vs-mouse-jiggler`) and **do not create** localized WP pages under `de`/`es`/`fr`/`pt-br` (theme handles those URLs).

5. **Set to Draft** (after deploy so 301s apply):

| Slug | Reason |
|------|--------|
| `prevent-teams-away` | Consolidated into `/keep-teams-active/` |
| `keep-teams-icon-green` | Same (anchor `#keep-teams-icon-green` on Teams page) |

6. Confirm existing `/download/` and `/contacts/` keep those slugs (do **not** rename to `downloads` / `contact`).

---

## URLs to test after deploy

- `/` (home, WebP hero)
- `/features/`, `/how-it-works/`, `/keep-teams-active/`, `/keep-slack-active/`
- `/teams-away-status/`, `/prevent-computer-sleep/`, `/is-noaway-safe/` (signing + no-refund copy)
- `/de/keep-teams-active/`, `/es/keep-teams-active/`, `/pt-br/keep-teams-active/`, `/fr/keep-teams-active/` (no WP pages needed)
- `/de/keep-slack-active/`, `/es/keep-slack-active/`, `/pt-br/keep-slack-active/`, `/fr/keep-slack-active/`
- `/download/`, `/downloads/` (must 301 → `/download/`), `/contacts/`, `/faq/`, `/help/`, `/sitemap/`
- `/prevent-teams-away` and `/keep-teams-icon-green` → 301 `/keep-teams-active/`
- `/noaway-vs-*` should **404** (not in sitemap; do not create WP pages)
- `/sitemap.xml`, `/robots.txt`, `/llms.txt`
- Buy CTA → checkout; cookie banner; email-link flow if used

---

## Open TODOs still in theme (not blocking this deploy)

Comparison data in `inc/noaway-comparisons.php` remains in the repo for a later release; pages are not published.

Optional polish on `/is-noaway-safe/` (comments only / hedging copy already safe):

- Trust signals (reviews, AV false positives)
- Exact OS idle APIs
- Network exceptions (updates / crash reports)
- Admin edge cases
- Open-source wording (already says commercial)

---

## Redirect map (no loops)

| From | To |
|------|-----|
| `/prevent-teams-away` | `/keep-teams-active/` |
| `/keep-teams-icon-green` | `/keep-teams-active/` |
| `/keep-microsoft-teams-active` | `/keep-teams-active/` |
| `/keep-active`, `/keep-active-native`, `/keep-ticks-active`, `/keep-testimonials` | `/` |
| `/downloads` | `/download/` |

Not redirected (live pages): `/download/`, `/contacts/`, `/keep-teams-active/`, `/`.  
`/noaway-releases/*` never redirected.

---

## Rollback

```bash
cd ~/public_html/wp-content/themes && rm -rf noaway-theme && tar xzf ~/noaway-theme-backup-YYYY-MM-DD.tgz
```

Replace `YYYY-MM-DD` with the backup date (e.g. `2026-10-12`).
