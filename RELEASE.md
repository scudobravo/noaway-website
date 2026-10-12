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
| NoAway vs PowerToys Awake | `noaway-vs-powertoys-awake` | Compare NoAway |
| NoAway vs Amphetamine | `noaway-vs-amphetamine` | Compare NoAway |
| NoAway vs Caffeine | `noaway-vs-caffeine` | Compare NoAway |
| NoAway vs Mouse Jiggler | `noaway-vs-mouse-jiggler` | Compare NoAway |
| Downloads | `download` (keep singular — live URL) | Downloads NoAway |
| FAQ | `faq` | FAQ NoAway |
| Contacts | `contacts` | Contatti NoAway |
| Help | `help` | Help NoAway |
| Sitemap | `sitemap` | Sitemap NoAway |
| Privacy Policy | `privacy-policy` | Privacy Policy NoAway |
| Terms of Service | `terms-of-service` | Terms of Service NoAway |
| Thank You | `thank-you` | Thank You (NoAway) |

5. **Localized landings** (`/de/`, `/es/`, `/pt-br/`, `/fr/`):

   The theme serves these on 404 via `noaway_i18n_template_redirect` **without** WP pages. Optional but recommended for cleaner admin: create parent pages `de`, `es`, `fr`, `pt-br`, then children:

| Parent slug | Child slug | Template |
|-------------|------------|----------|
| `de` | `keep-teams-active` | Keep Teams Active (Deutsch) |
| `es` | `keep-teams-active` | Keep Teams Active (Español) |
| `fr` | `keep-teams-active` | Keep Teams Active (Français) |
| `pt-br` | `keep-teams-active` | Keep Teams Active (Português) |
| `de` | `keep-slack-active` | Keep Slack Active (Deutsch) |
| `es` | `keep-slack-active` | Keep Slack Active (Español) |
| `fr` | `keep-slack-active` | Keep Slack Active (Français) |
| `pt-br` | `keep-slack-active` | Keep Slack Active (Português) |

6. **Set to Draft** (after deploy so 301s apply):

| Slug | Reason |
|------|--------|
| `prevent-teams-away` | Consolidated into `/keep-teams-active/` |
| `keep-teams-icon-green` | Same (anchor `#keep-teams-icon-green` on Teams page) |

7. Confirm existing `/download/` and `/contacts/` keep those slugs (do **not** rename to `downloads` / `contact`).

---

## URLs to test after deploy

- `/` (home, WebP hero)
- `/features/`, `/how-it-works/`, `/keep-teams-active/`, `/keep-slack-active/`
- `/teams-away-status/`, `/prevent-computer-sleep/`, `/is-noaway-safe/`
- `/noaway-vs-powertoys-awake/`, `/noaway-vs-amphetamine/`, `/noaway-vs-caffeine/`, `/noaway-vs-mouse-jiggler/`
- `/de/keep-teams-active/`, `/es/keep-teams-active/`, `/pt-br/keep-teams-active/`, `/fr/keep-teams-active/`
- `/de/keep-slack-active/`, `/es/keep-slack-active/`, `/pt-br/keep-slack-active/`, `/fr/keep-slack-active/`
- `/download/`, `/downloads/` (must 301 → `/download/`), `/contacts/`, `/faq/`, `/help/`, `/sitemap/`
- `/prevent-teams-away` and `/keep-teams-icon-green` → 301 `/keep-teams-active/`
- `/sitemap.xml`, `/robots.txt`, `/llms.txt`
- Buy CTA → checkout; cookie banner; email-link flow if used

---

## Open TODOs in theme (file:line)

### Visible risk if published unconfirmed (competitor / trust claims on live HTML)

Comments are HTML-hidden, but **table/FAQ cell text still shows**. Confirm before treating comparison pages as final:

| Location | Topic |
|----------|--------|
| `inc/noaway-comparisons.php:52–82` | PowerToys Awake platforms, presence, modes, admin, price, setup |
| `inc/noaway-comparisons.php:92–104,122–127` | PowerToys org policy, maintenance, docs, macOS absence |
| `inc/noaway-comparisons.php:150–180,190–198,215–220` | Amphetamine OS, presence, triggers, install, price, distribution |
| `inc/noaway-comparisons.php:243–273,283–291,308–313` | Which “Caffeine”, idle behavior, modes, privileges, price, maintenance |
| `inc/noaway-comparisons.php:336–366,376–384,401–406` | Mouse jiggler scope, failure modes, sleep vs idle, corporate policy, price |
| `page-compare.php:59` | Verdict length ~50 words (editorial) |
| `page-is-noaway-safe.php:35` | Third-party trust signals |
| `page-is-noaway-safe.php:46` | Exact OS idle APIs |
| `page-is-noaway-safe.php:60` | Network: license / updates / crash reports |
| `page-is-noaway-safe.php:72` | Admin rights edge cases |
| `page-is-noaway-safe.php:93–94` | **macOS signing/notarization + Windows Authenticode** — page hedges; do not imply signed until confirmed |
| `page-is-noaway-safe.php:102` | Open-source status (copy already says commercial/not OSS) |
| `page-is-noaway-safe.php:110` | **Consumer refund window** (EU / Stripe) — not stated numerically; still confirm before ads |

### Lower risk

- `page-compare.php:81–82,115,151` — HTML comments only echoing `competitor_todo` / `todo` (not shown to users).

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
