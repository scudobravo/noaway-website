# Graph Report - website  (2026-10-22)

## Corpus Check
- 93 files · ~3,327,692 words
- Verdict: corpus is large enough that graph structure adds value.

## Summary
- 392 nodes · 623 edges · 77 communities (72 shown, 5 thin omitted)
- Extraction: 81% EXTRACTED · 19% INFERRED · 0% AMBIGUOUS · INFERRED: 118 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Graph Freshness
- Built from commit: `95ecf0d7`
- Run `git rev-parse HEAD` and compare to check if the graph is stale.
- Run `graphify update .` after code changes (no API cost).

## Community Hubs (Navigation)
- noaway-pages.php
- noaway-i18n.php
- noaway-seo.php
- noaway-email-link.php
- package.json
- RELEASE — first production deploy (SEO/AEO/GEO phases 1–5)
- noaway-sitemap.php
- cta-tracking.js
- cta-tracking.php
- Ottimizzazioni performance (Lighthouse)
- WordPress (noaway.app)
- noaway-comparisons.php
- NoAway API
- inc/noaway-analytics.php
- NoAway — protected downloads (`api/`)
- noaway_rate_limit_check
- noaway-email-link.js
- noaway-i18n-locale-banner.js
- licenseKey.php
- wp-cli.sh
- wp-install.sh
- noaway-contact.php
- tailwind.config.js
- Diff testo visibile (git HEAD → working tree)
- audit-l.py
- Prompt L — esito
- Prompt L — audit live (pre-deploy baseline)

## God Nodes (most connected - your core abstractions)
1. `noaway_fact()` - 21 edges
2. `noaway_seo_canonical_url()` - 21 edges
3. `noaway_i18n_normalize_lang()` - 20 edges
4. `noaway_seo_structured_data()` - 20 edges
5. `noaway_seo_get_page_data()` - 18 edges
6. `Diff testo visibile (git HEAD → working tree)` - 18 edges
7. `noaway_i18n_current_landing()` - 15 edges
8. `noaway_i18n_landing_url()` - 15 edges
9. `noaway_page_url_by_template()` - 15 edges
10. `noaway_i18n_tokens()` - 12 edges

## Surprising Connections (you probably didn't know these)
- `noaway_ai_feed_links_in_head()` --calls--> `noaway_seo_canonical_url()`  [INFERRED]
  wordpress/wp-content/themes/noaway-theme/inc/noaway-ai-discovery.php → wordpress/wp-content/themes/noaway-theme/inc/noaway-seo.php
- `noaway_slack_presence_source_html()` --calls--> `noaway_i18n_normalize_lang()`  [INFERRED]
  wordpress/wp-content/themes/noaway-theme/inc/noaway-i18n-slack.php → wordpress/wp-content/themes/noaway-theme/inc/noaway-i18n.php
- `noaway_i18n_raw()` --calls--> `noaway_i18n_tokens()`  [INFERRED]
  wordpress/wp-content/themes/noaway-theme/inc/noaway-ui.php → wordpress/wp-content/themes/noaway-theme/inc/noaway-i18n.php
- `noaway_sitemap_page_url()` --calls--> `noaway_seo_canonical_url()`  [INFERRED]
  wordpress/wp-content/themes/noaway-theme/inc/noaway-sitemap.php → wordpress/wp-content/themes/noaway-theme/inc/noaway-seo.php
- `noaway_output_llms_txt()` --calls--> `noaway_fact()`  [INFERRED]
  wordpress/wp-content/themes/noaway-theme/inc/noaway-ai-discovery.php → wordpress/wp-content/themes/noaway-theme/inc/noaway-facts.php

## Import Cycles
- None detected.

## Communities (77 total, 5 thin omitted)

### Community 0 - "noaway-pages.php"
Cohesion: 0.08
Nodes (36): noaway_ai_discovery_template_redirect(), noaway_ai_feed_links_in_head(), noaway_output_ai_faq_json(), noaway_output_ai_json(), noaway_output_ai_service_json(), noaway_output_ai_summary_json(), noaway_output_ai_txt(), noaway_output_llms_txt() (+28 more)

### Community 1 - "noaway-i18n.php"
Cohesion: 0.12
Nodes (42): noaway_i18n_bcp47(), noaway_i18n_buy_cta_label(), noaway_i18n_current_landing(), noaway_i18n_enqueue_guide_assets(), noaway_i18n_ensure_guide_page(), noaway_i18n_ensure_lang_parent(), noaway_i18n_ensure_localized_pages(), noaway_i18n_find_page_by_template() (+34 more)

### Community 2 - "noaway-seo.php"
Cohesion: 0.11
Nodes (33): noaway_fact(), noaway_fact_benefit_with_help_plain(), noaway_fact_data_sent_paragraph(), noaway_fact_i18n(), noaway_facts(), noaway_facts_todos(), noaway_i18n_slack_copies(), noaway_slack_presence_source_html() (+25 more)

### Community 3 - "noaway-email-link.php"
Cohesion: 0.13
Nodes (17): noaway_email_link_bump_rate_limit(), noaway_email_link_check_rate_limit(), noaway_email_link_client_ip(), noaway_email_link_downloads_url(), noaway_email_link_enqueue_assets(), noaway_email_link_ip_hash(), noaway_email_link_mail_url(), noaway_email_link_rest_handler() (+9 more)

### Community 4 - "package.json"
Cohesion: 0.18
Nodes (10): fast-glob, tailwindcss, devDependencies, fast-glob, tailwindcss, name, private, scripts (+2 more)

### Community 5 - "RELEASE — first production deploy (SEO/AEO/GEO phases 1–5)"
Cohesion: 0.18
Nodes (10): Added / updated in this pre-release pass, Deploy package (vs previous live theme), Full deploy inventory (copied by `.cpanel.yml`), Open TODOs still in theme (not blocking this deploy), Product decisions (locked for this release), Redirect map (no loops), RELEASE — first production deploy (SEO/AEO/GEO phases 1–5), Rollback (+2 more)

### Community 6 - "noaway-sitemap.php"
Cohesion: 0.21
Nodes (11): noaway_content_modified(), noaway_render_last_reviewed(), noaway_get_sitemap_urls(), noaway_output_sitemap_xml(), noaway_robots_discovery_url(), noaway_robots_txt_sitemap(), noaway_sitemap_lastmod(), noaway_sitemap_normalize_absolute_url() (+3 more)

### Community 7 - "cta-tracking.js"
Cohesion: 0.39
Nodes (11): analyticsAllowed(), bindClicks(), cameFromEmailLink(), init(), postEvent(), readAttribution(), rememberEmailRef(), saveAttribution() (+3 more)

### Community 8 - "cta-tracking.php"
Cohesion: 0.31
Nodes (7): noaway_analytics_cta_attribution_rows(), noaway_analytics_cta_install_table(), noaway_analytics_cta_rest_handler(), noaway_analytics_cta_table(), noaway_analytics_email_link_sent_record(), noaway_analytics_email_link_totals(), WP_REST_Request

### Community 9 - "Ottimizzazioni performance (Lighthouse)"
Cohesion: 0.25
Nodes (7): Apache (.htaccess), Build Tailwind (per produzione / mobile), Cache degli asset (Lighthouse: "Use efficient cache lifetimes"), Cosa fa già il tema, Immagine hero, Nginx, Ottimizzazioni performance (Lighthouse)

### Community 10 - "WordPress (noaway.app)"
Cohesion: 0.29
Nodes (6): Blocco Gutenberg, Deploy, Download protetti, Email post-acquisto (license-server), Tema `noaway-theme`, WordPress (noaway.app)

### Community 11 - "noaway-comparisons.php"
Cohesion: 0.43
Nodes (7): noaway_compare_page_url(), noaway_comparison_noaway_defaults(), noaway_comparisons(), noaway_get_comparison(), noaway_get_comparison_for_current_page(), noaway_page_url_by_template_and_slug(), noaway_vs_powertoys_awake_page_url()

### Community 12 - "NoAway API"
Cohesion: 0.33
Nodes (5): Configurazione, Locale (Docker), NoAway API, Posizione, URL per l’app Electron

### Community 14 - "NoAway — protected downloads (`api/`)"
Cohesion: 0.40
Nodes (4): Files, Nginx, NoAway — protected downloads (`api/`), Platforms (`p` parameter)

### Community 15 - "noaway_rate_limit_check"
Cohesion: 0.50
Nodes (3): noaway_get_pdo(), noaway_client_ip(), noaway_rate_limit_check()

### Community 16 - "noaway-email-link.js"
Cohesion: 0.70
Nodes (4): analyticsAllowed(), init(), initForm(), trackEvent()

### Community 17 - "noaway-i18n-locale-banner.js"
Cohesion: 0.60
Nodes (3): dismiss(), isDismissed(), storageKey()

### Community 25 - "noaway-contact.php"
Cohesion: 0.22
Nodes (15): noaway_favicon_wp_head(), noaway_theme_image_url(), noaway_contact_allowed_topics(), noaway_contact_auto_reply_html(), noaway_contact_bump_rate_limit(), noaway_contact_check_rate_limit(), noaway_contact_client_ip(), noaway_contact_email_logo_url() (+7 more)

### Community 69 - "Diff testo visibile (git HEAD → working tree)"
Cohesion: 0.11
Nodes (18): Diff testo visibile (git HEAD → working tree), `wordpress/wp-content/themes/noaway-theme/front-page.php`, `wordpress/wp-content/themes/noaway-theme/header.php`, `wordpress/wp-content/themes/noaway-theme/inc/noaway-pages.php`, `wordpress/wp-content/themes/noaway-theme/page-downloads.php`, `wordpress/wp-content/themes/noaway-theme/page-faq.php`, `wordpress/wp-content/themes/noaway-theme/page-features.php`, `wordpress/wp-content/themes/noaway-theme/page-how-it-works.php` (+10 more)

### Community 70 - "audit-l.py"
Cohesion: 0.52
Nodes (6): audit_page(), contrast_ratio(), fetch_urls(), main(), parse_rgb(), slug()

### Community 75 - "Prompt L — esito"
Cohesion: 0.25
Nodes (7): Audit live (tema ancora vecchio in produzione), Contrasto Prompt B (calcolato), Deploy, Diff testo (git HEAD → working tree), Prompt L — esito, Screenshot, TODO(Andrea) introdotti dalla revisione UI

### Community 76 - "Prompt L — audit live (pre-deploy baseline)"
Cohesion: 0.40
Nodes (4): Contrast < 4.5 (campione live), Overflow, Prompt L — audit live (pre-deploy baseline), Touch < 44px @390

## Knowledge Gaps
- **59 isolated node(s):** `wp-cli.sh script`, `wp-install.sh script`, `name`, `private`, `build` (+54 more)
  These have ≤1 connection - possible missing edges or undocumented components.
- **5 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `noaway_seo_canonical_url()` connect `noaway-seo.php` to `noaway-pages.php`, `noaway-i18n.php`, `noaway-email-link.php`, `noaway-sitemap.php`, `noaway-comparisons.php`?**
  _High betweenness centrality (0.049) - this node is a cross-community bridge._
- **Why does `noaway_fact()` connect `noaway-seo.php` to `noaway-pages.php`, `noaway-contact.php`?**
  _High betweenness centrality (0.038) - this node is a cross-community bridge._
- **Why does `noaway_seo_get_page_data()` connect `noaway-seo.php` to `noaway-i18n.php`, `noaway-comparisons.php`?**
  _High betweenness centrality (0.027) - this node is a cross-community bridge._
- **Are the 15 inferred relationships involving `noaway_fact()` (e.g. with `noaway_output_llms_txt()` and `noaway_contact_auto_reply_html()`) actually correct?**
  _`noaway_fact()` has 15 INFERRED edges - model-reasoned connections that need verification._
- **Are the 12 inferred relationships involving `noaway_seo_canonical_url()` (e.g. with `noaway_ai_feed_links_in_head()` and `noaway_output_ai_summary_json()`) actually correct?**
  _`noaway_seo_canonical_url()` has 12 INFERRED edges - model-reasoned connections that need verification._
- **Are the 2 inferred relationships involving `noaway_i18n_normalize_lang()` (e.g. with `noaway_slack_presence_source_html()` and `noaway_refund_near_price_html()`) actually correct?**
  _`noaway_i18n_normalize_lang()` has 2 INFERRED edges - model-reasoned connections that need verification._
- **Are the 8 inferred relationships involving `noaway_seo_structured_data()` (e.g. with `noaway_fact_i18n()` and `noaway_i18n_bcp47()`) actually correct?**
  _`noaway_seo_structured_data()` has 8 INFERRED edges - model-reasoned connections that need verification._