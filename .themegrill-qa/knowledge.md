# Radiate — QA Knowledge

Draft, not final (generated 2026-09-24 by `knowledge-init`). See "Needs a
human" at the bottom before trusting the critical-flow ordering, the
expected-behaviour claims without a citation, or the known-non-issues list.

## Product

- Radiate (free) 1.4.3, text domain `radiate`, entry `style.css`. Pro sibling:
  `radiate-pro` 2.3.5 — a separate standalone codebase, not a child theme or
  add-on. Shared-looking code must be verified on each tier independently;
  the 2026-09-17 audit found two of three Free bugs shared, one Pro-only fix.
- `style.css` declares `Tested up to: 6.8`, `Requires PHP: 5.6`. The audit
  ran on WP 7.1 / PHP 8.2–8.5 with no Radiate-originated fatals or notices
  (not an exhaustive compatibility pass — Jira ST-935).
- Classic PHP theme. No blocks, no REST routes, no CPTs, no shortcodes, no
  custom tables, no `woocommerce/` template overrides.
- Assets on every front-end view (`functions.php` `radiate_scripts`): Google
  Fonts (Roboto + Merriweather, external), Genericons 3.3.1, `navigation.js`,
  `skip-link-focus-fix.js`, `custom.js` (jQuery), `html5shiv.js`.

## Settings surfaces (source-derived)

All in `inc/customizer.php`, all `edit_theme_options`. No settings API pages.

| Section (id) | Setting (theme mod) | Control | Default | Sanitize |
|---|---|---|---|---|
| `radiate_upsell_section` | — (link to Pro) | custom section type | — | — |
| `title_tagline` (renamed "Site Title") | core; **`blogdescription` control removed** (:40) | — | — | — |
| `colors` (core) | `radiate_color_scheme` | color | `#632E9B` | `radiate_sanitize_hex_color` |
| `radiate_custom_css_section` — **only if `wp_update_custom_css_post()` does not exist** (WP < 4.7) | `radiate_custom_css` | textarea | `''` | `wp_filter_nohtml_kses` |
| `radiate_featured_section` "Front Page Featured Section" | `page-setting-one` / `-two` / `-three` | dropdown-pages | none | `radiate_sanitize_integer` |
| `radiate_related_posts_section` | `radiate_related_posts_activate` | checkbox | 0 | `radiate_checkbox_sanitize` |
| | `radiate_related_posts` | radio `categories` / `tags` | `categories` | `radiate_sanitize_radio` |
| `radiate_author_bio` | `radiate_author_bio_show` | checkbox | 0 | checkbox |
| `radiate_search_icon` | `radiate_header_search_hide` | checkbox | 0 | checkbox |
| `radiate_menu_section` "Responsive Menu Style" | `radiate_new_menu_enable` → body class `full-width-menu` | checkbox | 0 | checkbox |
| | `radiate_responsive_menu_style` → body class `better-responsive-menu` | checkbox | 0 | checkbox |

Core surfaces the theme opts into (`functions.php`, `inc/custom-header.php`):
custom header (Header Media, parallax `#parallax-bg`), custom background
(default `EAEAEA`), one nav location `primary`, one sidebar "Sidebar",
post formats (aside/image/video/quote/link), WooCommerce + gallery
zoom/lightbox/slider, Jetpack infinite scroll, image size
`featured-image-medium` 768×350.

Live preview: `blogname`, `blogdescription`, `header_textcolor` are
`postMessage` (`js/customizer.js`). Everything else refreshes.

Admin surfaces:
- Appearance → "Radiate Options" (`radiate-options`,
  `inc/admin/class-radiate-dashboard.php:46`, `edit_theme_options`).
- Welcome notice with a demo-import button → AJAX `wp_ajax_import_button`
  (`class-radiate-welcome-notice.php:10,103`), nonce
  `radiate_demo_import_nonce`, `manage_options`.
- Upgrade notice and theme-review notice, both dismissible via nonced GET.

## Persistence

- Theme mods: the 11 settings above, plus core `header_image`,
  `header_image_data`, `background_*`, `nav_menu_locations`.
- Options: `radiate_theme_installed_time`, `radiate_upgrade_notice_start_time`,
  `radiate_admin_notice_welcome` (plus `radiate_admin_notice_*` on dismiss).
- No post meta, no custom tables.
- Front page featured pages are read as
  `get_theme_mod('page-setting-one'…)` in `front-page.php:13`, and the section
  renders only if at least one is non-zero.
- Primary colour CSS is output inline in `wp_head` only when the value is
  set and `!= '#632e9b'` (`inc/customizer.php:406`). Lower-case compare
  against an upper-case default: TODO confirm `#632E9B` saved explicitly
  does not emit a redundant block.

## Capability boundaries

| Surface | Gate | Source |
|---|---|---|
| Customizer settings | `edit_theme_options` | `inc/customizer.php` |
| Theme options page | `edit_theme_options` | `class-radiate-dashboard.php:46` |
| Welcome notice, demo-import AJAX | `manage_options` + `radiate_demo_import_nonce` | `class-radiate-welcome-notice.php:36,104-106` |
| Plugin install/activate in notice | `activate_plugin` | `class-radiate-welcome-notice.php:128,169` |
| Upgrade notice dismiss | `publish_posts` + nonce | `class-radiate-notice.php:58-81`, `class-radiate-upgrade-notice.php:8` |
| Theme-review notice dismiss | nonce | `class-radiate-theme-review-notice.php:152,170` |
| "Ready to publish" prompt on empty blog | `publish_posts` | `content-none.php:19` |

Audit note: Free's notice classes pair `wp_verify_nonce()` with
`sanitize_text_field( wp_unslash() )` consistently. The author social-link
XSS and meta-box sanitisation gaps in the research report are **Pro-only**
(`radiate-pro/inc/extras.php`, `inc/meta-box.php`); Free has neither file path.

## Migrations / upgrade handling

- One migration: `radiate_custom_css_migrate()` (`inc/extras.php`, on
  `after_setup_theme`). It appends theme mod `radiate_custom_css` to core
  Additional CSS, then removes the theme mod. It runs on every load until
  the mod is gone. Commit a0063bc fixed its hook once.
- No DB version option, no versioned upgrade routines.

## Fragile areas (git history, 246 commits)

- **Mobile / responsive menu** — the clearest hot spot. Fix commits:
  aa5b950 (#5), 7c58345, abd060d, 9545764, 0986d8b, d9d7377, a52d441,
  16903bd (sticky header on responsive), 543e133 (#41, mobile menu with
  full-width style off), 667c021 (#16, a11y). Files: `js/navigation.js`,
  `header.php`, the responsive blocks of `style.css`. There are still open
  a11y defects today (radiate#52).
- **Header / fixed header offset** — 16903bd, and radiate#53 is open (see
  Known issues).
- **Customizer** — `inc/customizer.php` modified in 18 commits
  (7a607a6 sanitisation, ddf44d9 default colour).
- **Related posts** — 5dffdbf (posts per page), 6fc2d67 (CSS).
- **Search** — 26aff6f (#50).
- Most-modified files, excluding readme and version bumps: `style.css` (59),
  `functions.php` (26), `inc/customizer.php` (18), `inc/extras.php` (13),
  `header.php` (13), `inc/admin/class-radiate-admin.php` (11).

## Critical flows — TODO: confirm ordering with a human

Proposed from the source surfaces plus the 2026-09-17 audit. The order is a
guess. `suite-index.mjs` derives `areas_uncovered` from this list, so a
wrong list misdirects every later effort.

1. **homepage** — front page renders, header image/parallax, clean console, single h1
2. **mobile-menu** — toggle open/close ≤600px, submenus, full-width and better-responsive styles, keyboard/ARIA
3. **header** — site title/logo, header image, search icon show/hide, fixed-header offset with admin bar
4. **featured-pages** — Front Page Featured Section: 1–3 selected pages render in order with excerpt + Read more
5. **customizer** — primary colour → preview → publish → front end; all 11 settings persist
6. **blog** — archive, single, post formats, comments threading, pagination
7. **related-posts** — on/off, by categories vs tags, 3 random posts, none when no tags
8. **author-bio** — single-post author box when enabled and the author has a description
9. **search** — results, zero results, search form in header
10. **woocommerce** — shop → product (incl. variable) → cart → coupon → checkout → confirmation
11. **demo-import** — welcome notice → Starter Templates → free "Radiate" demo
12. **widgets** — single "Sidebar" area
13. **admin-notices** — welcome/upgrade/review notices show, dismiss and stay dismissed

## Expected behaviour

### Live-verified in the 2026-09-17 audit (radiate-qa-report.html)
- Category archive, tag archive, populated search and zero-result search
  ("Nothing Found" + working retry form) render correctly with labelled
  search inputs.
- Threaded comments nest correctly on single posts and in the Recent
  Comments widget.
- WooCommerce: 8-product shop grid, sale badge, sorting; the variable
  product's size dropdown and price range work. Guest checkout works end to
  end: a 10% coupon takes $9.99 to $8.99 → COD → order confirmation with the
  correct number, total and method. The empty cart shows "Your cart is
  currently empty!".
- 768px: content reflows to a single column. 1024px: nav wraps to two rows.
  No horizontal overflow at either width.
- Contrast: links `#444` on white 9.7:1; the search button white on `#632E9B`
  8.8:1.
- A skip link (`.skip-link.screen-reader-text`) is present. Keyboard Tab
  reachability of submenus works (`navigation.js` `.focus` class).
- Switching themes did not migrate stray widgets into the sidebar.
- Starter Templates: 3 templates — "Radiate" (free), "Radiate Food" and
  "Radiate Pro" (Premium). Premium ones show a clean "Upgrade to Pro" modal
  with no partial import. The free demo's menu, featured section and posts
  import correctly (except the header image; see Known issues).

### From source
- Related posts query: 3 posts, `orderby rand`, excludes the current post.
  With `tags` selected and a post that has no tags, the result is empty
  (`inc/extras.php`).
- Header search icon shows unless `radiate_header_search_hide` is truthy
  (`header.php:55`).
- `woocommerce_breadcrumb` is deliberately removed and WooCommerce page
  titles are hidden (`inc/extras.php`). This is by design, not a regression.

### Stated by the docs (docs.themegrill.com/radiate, via `.themegrill-qa/docs/radiate.md`)
- "By default, the menus will fallback to Pages … just after activation of
  the theme, you will see all the pages as menus."
- Front Page Featured Section: "select the page from dropdown options to
  display it" → it appears on the home page after Save & Publish.
- Header image recommended size is 1500×450, with an optional crop.
- Header Search Icon "will allow you to enable/disable the search icon in
  your header section."
- Supported plugins: Social Icons, Easy Social Sharing (ThemeGrill).

TODO (human): expected behaviour for featured pages with fewer than 3 pages
selected (layout classes in `front-page.php`), the two responsive-menu
styles, and the author bio with no description.

## Known issues — as of the 2026-09-17 audit

- **radiate#52 (Major, a11y)** — the mobile toggle `<h4 class="menu-toggle"></h4>`
  (`header.php:63`) has no accessible name and no `aria-expanded`. Dropdown
  parents have no `aria-haspopup`/`aria-expanded`, and there's no visual
  caret. The toggle being an h4 causes a heading skip (H1→H4→H2) on mobile.
- **radiate#53 (Minor)** — logged-in at 375px, the fixed header sits under
  WP's mobile admin bar.
  **The root cause as filed is wrong for this checkout:** the issue says
  Free lacks the `@media (max-width:782px) { body.admin-bar .header-wrap
  { top:45px } }` override, but `style.css:1816-1823` has it, identical to
  Pro, and has since the initial commit (306b963). A likely real cause is
  `@media (max-width:600px) { body.admin-bar .header-wrap { top:0 } }`
  (`style.css:1974`). Core's admin bar is still 46px there, so a
  `position:fixed` header at `top:0` overlaps it. Measured 2026-09-24 at
  375px logged in: `#wpadminbar` is `position:absolute` at 0–46px, and
  `.header-wrap` is `position:fixed; top:0px`, so the header covers the bar
  completely (gap −46px). **TODO: correct the filed issue** before anyone
  ports "the Pro fix" that is already present. Guarded by the quarantined
  scenario in `tests/e2e/specs/header/fixed-header.spec.ts`.
- **Not filed yet — PHP deprecation on every front-end page (WP ≥ 6.9).**
  `functions.php:170` calls `wp_script_add_data( 'html5shiv', 'conditional',
  'lte IE 8' )`. WordPress 6.9 deprecated IE conditional comments, so with
  `WP_DEBUG_DISPLAY` on, every page prints "Deprecated: Function
  WP_Dependencies->add_data() was called with an argument that is deprecated
  since version 6.9.0" (seen on test-theme.local, WP 7.1). The fix is likely
  to drop html5shiv entirely (it's IE8-only). Quarantined scenario in
  `tests/e2e/specs/homepage/front-page-health.spec.ts`.
- **radiate#54 (Major, doc drift)** — see Doc drift, slider.
- **themegrill-demo-importer#133 (Major, shared)** — the free "Radiate"
  demo leaves `header_image_data.attachment_id` 239 pointing at a missing
  attachment. The parallax header is blank, with a 404 on
  `uploads/2020/12/header-image-one.jpg`. The fix belongs in the importer.
- Trivial, not filed: at 1440px a very long single nav label stretches the
  header full-bleed.
- Improvement backlog, not bugs (research report §10, §18): IE8
  `filter: alpha()` lines, no CSS custom properties, Merriweather 300 forced
  on buttons/inputs, weak `a:focus { outline: thin dotted }`, external Google
  Fonts, unconditional Genericons + html5shiv, and an unminified `style.css`.

## Doc drift

- `DOC DRIFT: https://docs.themegrill.com/radiate/ says "This theme supports
  the home page image slider … go to the Slider section", product does not
  have one` — no slider setting, section or template exists in Free; it is
  Pro-only. The themegrill.com Free vs Pro table also ticks it for Free.
  Filed as radiate#54. Also: the "Recommended image size for Slider –
  1400*600" line.
- `DOC DRIFT: docs say "Custom CSS Box is available in Appearance →
  Customize → Custom CSS", product only registers it when
  wp_update_custom_css_post() is missing (WP < 4.7)` — on any supported WP,
  custom CSS lives in core Additional CSS, and old values are migrated there.
- `DOC DRIFT: docs section "Site Title & Tagline" says the theme supports
  options for "site logo, title and tagline", product removes the
  blogdescription control (inc/customizer.php:40) and registers no
  custom-logo support in functions.php` — TODO confirm on a live Customizer
  whether logo/tagline controls appear.
- `DOC DRIFT: docs "Recommended Image Size" lists a block-layout size of
  830*370 and says "used in Spacious theme", product registers only
  featured-image-medium 768×350` — likely copy-paste from Spacious.
- Undocumented features: Related Posts, Author Bio and Responsive Menu
  Style have no docs article.
- **Docs content integrity:** the Custom Menu section of the live docs page
  contains an injected, off-topic paragraph promoting an online gambling
  platform ("pinup"). This looks like spam or SEO injection into
  docs.themegrill.com. A human should report it to whoever owns the docs site.

## Test harness notes

- The header search form hides its submit button by design
  (`style.css:744`); it submits on Enter. Don't report the button as missing.
- The fallback page menu's `<ul>` has zero height (floated items), so
  Playwright reports the list itself as hidden. Assert on its links instead.
- Never log in per spec. Parallel logins as the same WP user race on the
  `session_tokens` user meta and silently log one session out. Specs reuse
  the one session saved by `tests/e2e/auth.setup.ts`.
- wp-login.php's post-load scripts can race `fill()`. `auth.setup.ts`
  verifies both fields before submitting, and never prints their values.

## Known non-issues — TODO: confirm with a human

Seeded from the audit's own triage. A maintainer should confirm each one.
- No WooCommerce breadcrumb on shop pages — deliberate (`inc/extras.php`).
- No slider, footer widgets, left sidebar, font picker, per-page sidebar,
  or WP-PageNavi in Free — Pro-tier features (the per-page sidebar is
  feature request TT-3320).
- Duplicate Cart/Checkout/Shop pages after importing a demo on top of
  existing content — a test-setup artefact, not a Radiate bug.
- With Polylang active, menus falling back to the page list — Polylang's
  per-language `nav_menus` map, not the theme.
- Jira TT-3657 (Font Awesome v4) does not apply as written: Radiate ships
  Genericons, not Font Awesome.

## What must survive an upgrade — TODO: unknown, no human input yet

From source, the candidates are the 11 theme mods above, the migration of
`radiate_custom_css` into Additional CSS, the `primary` menu assignment,
and the "Sidebar" widget contents. A maintainer needs to say which ones are
promised.

## Sources

- Source: this checkout at 1.4.3 (db0a664), branch `add/claudegrill-qa-setup`.
- Docs: https://docs.themegrill.com/radiate/ (a single post, id 1122,
  modified 2026-08-06), hand-fetched to `.themegrill-qa/docs/radiate.md`.
  `ingest-docs.mjs` cannot read it: there's no `doc_category` for Radiate,
  and sitemap mode skips section landing pages. As a result there is no
  `docs-index.json`.
- Audit (site root `test-theme/`): `radiate-qa-report.html`,
  `radiate-theme-research-and-improvement-report.html`,
  `research-public-evidence.md`, `gh-issue-A/B/C-*.md`, `gh-comment-133.md`
  (2026-09-17). Pro-only items (radiate-pro#7, #8, author-link XSS) were
  excluded except where noted.
- Clean DB baseline: `test-theme/db-snapshots/radiate-qa-baseline-CLEAN-2026-09-17.sql`.

## Needs a human

- Critical-flow list and ordering (above): proposed, unconfirmed.
- Expected behaviour for featured pages with fewer than 3 pages, the two
  responsive-menu styles, and the author bio with no description.
- Known non-issues: seeded from the audit, unconfirmed.
- What must survive an upgrade: unknown.
- radiate#53's root cause: confirmed by measurement; correct the filed issue.
- html5shiv deprecation: file an issue, then add its key to the quarantined
  scenario's `@guards`.
- Docs spam paragraph: report it to the docs owner.
