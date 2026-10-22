# Prompt L — esito

## Screenshot

- **88 PNG** in `design-review/screens/` (live pre-deploy, 22 URL × 4 larghezze).
- `design-review/after/` è pronto: dopo deploy (o con URL locale) rieseguire `python3 design-review/audit-l.py` e spostare/salvare lì gli shot post-tema.

## Audit live (tema ancora vecchio in produzione)

| Check | Esito live |
|---|---|
| Overflow-x | 0 su tutte le URL campionate |
| Home @390 altezza | **12424 px** (obiettivo post-deploy &lt; 9000) |
| Immagini senza width/height/aspect | 0 nel campione |
| Contrasto &lt; 4.5 | segnalato su live (AVAILABLE, meta slate-500, icone decorative) — fix locali Prompt B |
| Touch &lt; 44px @390 | molti su live — fix locali Prompt K (`min-h-[44px]`, sticky Buy, cookie) |

Dettaglio: `AUDIT_L.md`, `audit-live.json`.

## Diff testo (git HEAD → working tree)

Estrazione automatica grezza: **nessuna modifica di copy intenzionale**. Differenze tipiche:

- titoli sezione ripetuti in TOC/chip FAQ (stesso testo già in pagina);
- stringhe spostate in `$args` di `cta-final` / guide layout (stesso wording);
- icone Material (`check_circle`, `cancel`, `expand_more`) — non copy;
- **corretto in L:** ripristinato heading **Overview** in sitemap (era sparito nel restyle card).

Blocco deploy per testo: **no**, dopo il fix Overview.

## Contrasto Prompt B (calcolato)

| Caso | Ratio |
|---|---|
| Banner `#fff` su `#ff5a00` (vecchio) | 3.13:1 |
| Banner `#0f172a` su `#ff5a00` (nuovo) | **5.71:1** |
| `slate-400` su bianco | 2.56:1 |
| `slate-600` su bianco | **7.58:1** |
| `slate-500` su `#f6f6f8` | 4.41:1 |
| Badge Available `green-700` su bianco | **5.02:1** |

## TODO(Andrea) introdotti dalla revisione UI

1. `template-parts/guide-toc.php` — heading visibile “On this page” (oggi solo `aria-label`).
2. `page-teams-away-status.php` — TOC/sticky Buy: CTA commerciale resta su `/keep-teams-active/` (giudizio layout).

(Altri `TODO(Andrea)` preesistenti in facts/releases non toccati da questa revisione.)

## Deploy

**Non eseguito** (piano: solo su richiesta dopo L). Prossimi passi quando ok:

1. Backup tema cPanel.
2. Push → `.cpanel.yml`.
3. Purge cache immagini.
4. Spot-check + rieseguire audit in `design-review/after/`.
