# TallCraftUI v3.x — Migration & Release Plan (Laravel 13 · Livewire 4 · Tailwind 4.3 · Alpine 3.17)

## Context

TallCraftUI (`developermithu/tallcraftui`, current release **v2.1.3** on default branch `2.x`) is a **Blade component library**, not an app: 59 Blade components (inline `render()` heredocs in `src/View/Components/**`), traits for Livewire hosts (`WithTcTable`, `WithTcToast`), one CSS file published to the host app, an installer command, and an image-upload route. It must run inside *other people's* Laravel apps, so "upgrading Laravel/Livewire/Tailwind/Alpine" means **changing what we declare, emit and test against**, not upgrading an app of our own.

Goal: ship **v3.0** that is officially compatible with the latest stable stack, with a real test safety net (there is none today), minimal user-facing breaks, and clean upgrade docs.

**Decisions (confirmed with maintainer):**
- Support matrix for 3.x: **PHP ^8.2 · Laravel ^12.0|^13.0 · Livewire ^4.0 only · Tailwind ^4.1**. `2.x` stays as the Livewire 3 maintenance line.
- `twMerge`: **spike first** (Phase 0), then decide whether to replace the merger.

---

## 1. Current-state assessment (verified 2026-09-29)

### Versions found vs. latest stable

| Item | In repo | Latest stable (verified) | Notes |
|---|---|---|---|
| PHP (declared) | none declared | — | Must add `"php": "^8.2"` |
| `illuminate/support` | `^10\|^11\|^12` | Laravel **v13.34.0** (PHP ^8.3) | L13 released 2026-03-17, “zero breaking changes” for apps; needs PHP 8.3+ |
| laravel/framework (lock, dev only) | v12.55.1 | v13.34.0 | lock file committed for a library |
| Livewire | **not declared at all** (implicit) | **v4.4.7** (PHP ^8.1, L10–13) | code uses `Livewire\WithPagination`, `#[Url]`, `$this->js()` |
| Alpine.js | not shipped (comes via Livewire) | **3.17.4** (Livewire 4 bundles `^3.17.4` + anchor, collapse, focus, intersect, mask, morph, persist, resize, sort) | all Alpine plugins we use are bundled |
| Tailwind CSS | CSS already v4-syntax (`@utility`, `@source`, `@plugin`) | **4.3.3**; `@tailwindcss/forms` 0.5.11 | 4.2 deprecated `start-*`/`end-*` insets |
| gehrisandro/tailwind-merge-laravel | ^1.3 (lock 1.4.0) | 1.4.0 → **requires laravel ^12\|^13, PHP ^8.2** | ⇒ advertised L10/L11 support is already broken |
| gehrisandro/tailwind-merge-php | 1.2.0 | 1.2.0 | changelog claims **Tailwind 3.4** support only |
| blade-ui-kit/blade-heroicons | ^2.6 (2.7.0) | 2.7.0 (L9–13) | OK |
| laravel/pint | ^1.21 | 1.29.x | OK |
| Node / package.json | none | — | no JS build in repo |
| Tests / CI | **none** (only dependabot for composer) | — | biggest process risk |

### Compatibility risks found in code (with locations)

**Livewire 4**
- **`@entangle` Blade directive is deprecated in v4** (“causes issues when removing DOM elements”). Used in 8 components: `Modal.php:30`, `Drawer.php:58`, `Tab/Tab.php:26`, `Accordion/Accordion.php:24`, `ColorPicker.php:220`, `Rating.php:45`, `Password.php:51` (passes `->value()`, so `.live` modifiers are silently lost), `Markdown.php:52`.
- **`Livewire.hook('request', …fail…)` is deprecated** in favour of `Livewire.interceptRequest(... onError({ responseBody, preventDefault }))` — `Toast.php:130-143` (drives server-side error toasts + `prevent_default` contract).
- `wire:model` on containers now ignores child events (`.self` by default); `.blur`/`.change` now also delay client-side sync. Our components mostly forward `wire:model` to real inputs (safe), but the modifiers users pass through `$attributes` change meaning → document.
- `$wire.set/get` with dynamic names in `Select.php:74-86`, `ColorPicker.php:256` — still supported; re-verify.
- `WithTcTable::updated()` (`src/Traits/WithTcTable.php:28`) is a bare lifecycle hook: any host component defining `updated()` silently disables search/per-page reset. Livewire supports trait-prefixed hooks (`updatedWithTcTable`).
- `x-on:livewire:navigating.window` (`Markdown.php:105`), `@persist` (`Toast.php`), `wire:navigate` (Button, MenuItem, DropdownItem, BreadcrumbItem), `$this->redirect(navigate: true)` — verify under v4 navigate.
- Livewire v4 URLs are now `/livewire-{hash}/…` — not used by us, nothing to change.

**Alpine**
- Relies on bundled plugins: `x-anchor` (`HasDropdownPosition.php`, `Select.php:325`), `x-trap.inert.noscroll` (Modal, Drawer), `x-collapse` (AccordionItem), `$persist` (3 files), `x-teleport` (Drawer). All bundled by Livewire 4 → keep, but installer/docs must warn **not to load a second Alpine**.
- Large inline `x-data` object literals with functions (Select, Markdown, ColorPicker, Toast) and global functions in an inline `<script>` (`Toast.php:79-145` defines `window.toast`, `getPositionStyle`, … on `window`) → **incompatible with Livewire 4 `csp_safe` mode** and pollute globals.

**Tailwind 4**
- Published `tallcraftui.css` has **no `@custom-variant dark`**, but `ThemeToggle` toggles a `.dark` class → in v4 `dark:` defaults to `prefers-color-scheme`, so the toggle doesn't work unless the host added the variant.
- `primary`/`secondary` colours (`HasButtonColors.php:44-45`, css `tc-pagination`) require host `@theme { --color-primary … }`; not provided or installed.
- v3 leftovers: `bg-opacity-90` (`Tooltip.php:73,97`, removed in v4 → no-op), `outline-none` (`Select.php`, v4 meaning changed; v3 behaviour is `outline-hidden`), bare `ring`, and the scale-shifted `shadow-sm`/`rounded-sm`/`blur-sm` (Enums, Helpers, ~15 components) — need visual audit, not blind rename. `start-1/2` in `Markdown.php` (deprecated in 4.2).
- Installer `setupTailwindConfig()` edits `tailwind.config.js` (v3 concept) and shells out to install `@tailwindcss/forms`.
- **`twMerge` (117 call sites, 50 files) is backed by a Tailwind-3.4-aware merger**; v4 syntax in use (`pl-10!`, `bg-linear-to-t`, `shadow-xs`, `rounded-xs`, `ring-3`) may merge incorrectly → user `class=` overrides silently dropped/duplicated.

**Security / hygiene (fix in 3.0, cheap now, expensive later)**
- `routes/web.php` upload: `disk` and `folder` come straight from the request, no server-side MIME/size validation, CSRF token passed in query string (`Markdown.php` uploadUrl) → arbitrary disk/path write, stored XSS via SVG/HTML.
- `WithTcTable` sorts on URL-controlled `sortCol` incl. arbitrary `relation.column` → exceptions/info leak.
- `composer.lock` committed in a library; `"minimum-stability": "dev"`.

### Deprecated APIs/patterns to replace
`@entangle` → `x-modelable` + forwarded `wire:model` (or `$wire.entangle()`); `Livewire.hook('request')` → `Livewire.interceptRequest`; `livewire:initialized` registration → `livewire:init`; `bg-opacity-*` → `/NN` colour modifier; `outline-none` → `outline-hidden`; `start-*`/`end-*` → 4.2 logical inset utilities (confirm exact names from 4.2 changelog); `tailwind.config.js` editing → CSS-first `@source/@plugin/@theme/@custom-variant`; bare `updated()` in trait → `updatedWithTcTable()`.

---

## 2. Framework upgrade strategy (order)

Because this is a package, order = **declare → test harness → behaviour**:

1. **Platform floor** (PHP ^8.2, Laravel ^12|^13) — mostly already forced by tailwind-merge-laravel 1.4. L13 brings no package-facing API changes we use (components, Blade, routes, Storage), only PHP 8.3+ for L13 legs.
2. **Livewire ^4.0** — highest risk; it also fixes the Alpine version (3.17.x) and plugin set.
3. **Alpine** — no separate dependency; adapt code to Livewire 4's Alpine & optional CSP mode.
4. **Tailwind ^4.1 (test on 4.3)** — already on v4 syntax; fix leftovers, installer, dark mode, merger.

Constraint table for CI: PHP 8.2 → L12 only; PHP 8.3/8.4/8.5 → L12 + L13; Livewire 4 `prefer-lowest` (4.0.x) and latest (4.4.x); Pest 3 on 8.2, Pest 4 on 8.3+ (or PHPUnit 11 everywhere).

Architecture impact: none on the component model (Blade components stay Blade components). New: an optional shipped JS asset (for CSP mode / Alpine.data registration) and a `package.json` for tests only.

---

## 3. Livewire 4 migration strategy

| Area | Change |
|---|---|
| **Two-way binding (8 comps)** | Replace `x-data="{ show: @entangle($attributes->wire('model')) }"` with root `x-data="{ show: false }" x-modelable="show" {{ $attributes->wire('model') }}` (Livewire 4's documented custom-input pattern; modifiers like `.live` flow through). For the non-bound case (Accordion/Tab without `wire:model`) keep local state. Password: fix lost modifiers. Markdown/ColorPicker/Rating: same pattern, keep `wire:ignore` where 3rd-party DOM (EasyMDE). |
| **Events** | `$dispatch('close')`, `close-modal.window`, `tallcraftui-toast` window event — unchanged; add Dusk/Playwright tests. |
| **Actions / JS** | `$this->js('toast(...)')` in `WithTcToast` still valid; keep `window.toast` as public API. |
| **Error toasts** | Rewrite `Toast.php` script: `document.addEventListener('livewire:init', () => Livewire.interceptRequest(({ onError }) => onError(({ responseBody, preventDefault }) => {…})))`. Keep JSON contract `{toast, prevent_default}` unchanged. |
| **Forms / validation** | Components read `$errors` server-side by `wire:model` name — unaffected. Document v4 `.blur/.change` semantics and `wire:model.live.blur` equivalents. |
| **Lifecycle** | `WithTcTable`: `updated()` → `updatedWithTcTable()`, keep `mountWithTcTable`. Keep `#[Url]` props & `WithPagination`. |
| **Navigate** | Verify `@persist('toast')`, `wire:navigate` links, `livewire:navigating` teardown in Markdown. |
| **Transitions** | We use Alpine `x-transition` only (not `wire:transition`) → unaffected. |

---

## 4. Tailwind CSS migration

- **CSS entry (`src/resources/css/tallcraftui.css`)**: add `@custom-variant dark (&:where(.dark, .dark *));` and default `@theme` tokens for `--color-primary`/`--color-secondary` (overridable by host); keep `@utility tc-table/table-striped/hoverable/tc-pagination`. Consider shipping the `@source` line inside the file so hosts need one `@import`.
- **Class audit**: `bg-opacity-90` → `bg-indigo-600/90` style; `outline-none` → `outline-hidden`; bare `ring` → `ring-1`/`ring-3` explicitly; review `shadow-sm/rounded-sm/blur-sm` against v2 screenshots (Enums `Shadow`, `BorderRadius` and Helpers are the single source for configurable ones); `start-1/2` → 4.2 replacement. Use `npx @tailwindcss/upgrade` only as a *linting aid* on a scratch copy — it can't parse PHP heredocs reliably.
- **Installer (`InstallTallcraftuiCommand`)**: delete `setupTailwindConfig()`; stop `shell_exec` installs (print the command instead, or use `Process`); idempotently add `@import './tallcraftui.css'`, `@plugin '@tailwindcss/forms'`, `@source`, `@custom-variant dark`; detect Flux/Jetstream/Breeze starter kits for `tc-` prefix.
- **Merger**: outcome of Phase 0 spike. If v4 conflicts fail → introduce `Support\ClassMerger` interface behind the existing `twMerge`/`twMergeFor` attribute macros, implemented by a v4-aware merger (vendored rule set or maintained fork). Macro names stay identical → no user break.

---

## 5. Alpine.js migration

- No `alpinejs` dependency; declare in docs “Alpine is provided by Livewire 4 (3.17.x) — do not import Alpine separately”.
- Directives/plugins in use (`x-anchor`, `x-trap`, `x-collapse`, `$persist`, `x-teleport`, `x-modelable`, `x-cloak`) all present in the Livewire 4 bundle → keep.
- **Should-have**: move Toast's inline `<script>` helpers into `Alpine.data('tcToast', …)` registered on `alpine:init`, delivered via `@assets`/a published JS file, removing `window.getPositionStyle` etc. globals. Same approach later for Select/ColorPicker/Markdown to become CSP-safe (`csp_safe => true`).
- `ThemeToggle` uses `localStorage` + `document.documentElement.classList` → fine; make sure it runs before paint and survives `wire:navigate`.

---

## 6. Codebase migration phases

Each phase = one PR into `3.x` (see §10 for branching).

### Phase 0 — Baseline & safety net (L) — **must happen first**
- **Objective**: be able to prove "no regression". Capture v2 behaviour before touching code.
- **Files**: new `tests/`, `workbench/` (orchestra/workbench), `phpunit.xml`/`Pest.php`, `package.json` (Vite + Tailwind 4 + Playwright, test-only), `.github/workflows/tests.yml`, `.github/dependabot.yml` (+ github-actions, npm).
- **Changes**: Testbench workbench app with a *kitchen-sink* page rendering every component in every variant, plus Livewire test components (form with all inputs, table with `WithTcTable`, toast triggers, modal/drawer bound to properties). Run it **on the 2.x branch with Livewire 3** to record golden screenshots + behaviour tests. twMerge spike: table-driven tests of v4 conflict pairs.
- **Deps**: none. **Risks**: workbench setup effort; flaky screenshots (fix fonts, disable animations).
- **Gate**: CI green on 2.x with baseline; merger spike report with go/no-go.

### Phase 1 — Platform & dependency constraints (S)
- `composer.json`: `"php": "^8.2"`, `illuminate/support|view|routing: ^12.0|^13.0`, **add `livewire/livewire: ^4.0`**, `gehrisandro/tailwind-merge-laravel: ^1.4`, `blade-heroicons: ^2.7`; dev: `orchestra/testbench ^10|^11`, `pestphp/pest ^3|^4`, `pestphp/pest-plugin-livewire`, `laravel/pint`. Remove `composer.lock` (gitignore), set `minimum-stability: stable`. Update keywords (“livewire 4”).
- **Gate**: `composer update --prefer-lowest` and latest both install on each matrix leg; Phase 0 PHP tests pass unchanged.

### Phase 2 — Livewire 4 core (L) — **highest risk**
- **Files**: `Modal.php`, `Drawer.php`, `Tab/Tab.php`, `Accordion/Accordion.php`, `ColorPicker.php`, `Rating.php`, `Password.php`, `Markdown.php`, `Select.php`, `Toast.php`, `Traits/WithTcTable.php`, `Traits/WithTcToast.php`.
- **Changes**: §3 table. Keep all prop names, events, and public PHP methods.
- **Risks**: `x-modelable` needs the bound element as root with `wire:model` on it — Modal/Drawer roots currently also carry `id`, `@close.window` etc. (fine); Drawer teleports to body (verify binding survives teleport); Markdown/EasyMDE re-init loops.
- **Validation**: Livewire feature tests (`Livewire::test`) + browser tests: open/close via property and via ESC/backdrop, `.live` vs deferred, persistent modal, error toast from 4xx/5xx JSON, `prevent_default`, table search/sort/per-page with host-defined `updated()`.

### Phase 3 — Alpine hygiene (M)
- **Files**: `Toast.php`, `ThemeToggle.php`, `Select.php`, `HasDropdownPosition.php`, new `resources/js/tallcraftui.js` (optional).
- **Changes**: §5. Namespace globals; `alpine:init` registration; no double-Alpine.
- **Validation**: browser tests with `wire:navigate` round-trips (no duplicate listeners, toast persists), dropdown anchoring positions, focus trap.

### Phase 4 — Tailwind 4.3 (M)
- **Files**: `src/resources/css/tallcraftui.css`, `Tooltip.php`, `Select.php`, `Markdown.php`, `Enums/Shadow.php`, `Enums/BorderRadius.php`, `Helpers/*`, `InstallTallcraftuiCommand.php`, (merger adapter if needed).
- **Changes**: §4.
- **Risks**: visual drift from scale renames; host apps that already defined their own dark variant/theme (make additions idempotent and overridable).
- **Validation**: visual regression vs Phase 0 baselines (light+dark, sm/lg viewports); installer tests against fixture `app.css` files (fresh L13 starter kit, existing TW4 app, already-installed).

### Phase 5 — Security & API hardening (M)
- **Files**: `routes/web.php`, `config/tallcraftui.php`, `Markdown.php`, `WithTcTable.php`, `Table/Tr.php`.
- **Changes**: upload route → controller with `image|max` validation, disk allowlist (`tallcraftui.upload.disks`), folder sanitising, `tallcraftui.upload.enabled` toggle, CSRF via header not query string. Sort allowlist: optional `tcSortableColumns(): array` — when present enforce; when absent log a deprecation (enforced in 4.0). `Tr` `onclick` → `wire:navigate`-aware link.
- **Validation**: feature tests for rejected disk/path/MIME, allowed upload; sort with unknown column ignored.

### Phase 6 — Docs, upgrade guide, release (M)
- README, docs site pages, `UPGRADE.md`, `CHANGELOG.md`, starter template. See §9.

---

## 7. Backward compatibility

**Must remain compatible in 3.x**: all component tags/names and `prefix` config; all props & boolean attribute variants; `class:*`/`twMergeFor` slots; config keys in `config/tallcraftui.php` (only additions); `WithTcToast` method signatures (`toast/success/warning/error/info`); `WithTcTable` public props (`tcSearch`, `tcPerPage`, `sortCol`, `sortAsc`) and URL aliases (`query`, `sortCol`, `sortAsc`); `window.toast()` JS API, `tallcraftui-toast` event, `{toast, prevent_default}` error JSON; `close`/`close-modal` events; `install:tallcraftui` command; publish tags.

**Breaking in 3.0 (the reason for the major)**: requires Livewire 4, Laravel 12+, PHP 8.2+, Tailwind 4.1+; upload route hardened (disk allowlist/validation may reject previously accepted requests); users relying on `wire:model.blur/.change` via our inputs get Livewire 4 semantics (upstream change, document).

**Deprecation notices in 3.x (removed in 4.0)**: table sorting without `tcSortableColumns()`; any compatibility shims for `.blur` semantics; legacy global JS helpers from Toast (kept one release as aliases); `tailwind.config.js` path in installer (just no-op + message).

**Reserved for 4.0**: renaming props/components, enforcing CSP-safe components everywhere, changing config structure, dropping Laravel 12.

---

## 8. Testing strategy

| Layer | Tooling | Coverage |
|---|---|---|
| Unit | Pest | Enums, Helpers (`BorderRadiusHelper`, `ShadowHelper`, …), size/colour traits, merger adapter (v4 conflict table) |
| Blade render / snapshot | Pest + Testbench `$this->blade()` | every component × key variants → HTML snapshot (catches accidental class/attr changes) |
| Feature | Testbench | upload route, installer command against fixture files, service provider registration with/without prefix |
| Livewire | `Livewire::test` | `WithTcTable` (search reset, per-page session, sort, relation sort), `WithTcToast` (dispatched JS, redirect), property-bound modal/drawer/tab/accordion |
| Browser / JS | Pest 4 browser (Playwright; Chromium already available) against workbench | open/close/ESC/backdrop/trap focus, select search & multi, dropdown anchor, toasts incl. error interceptor, theme toggle persistence, `wire:navigate` round-trips, Markdown editor upload |
| Visual regression | Playwright `toHaveScreenshot` on kitchen-sink, light/dark, 375px/1280px | baseline captured on 2.x in Phase 0; threshold per component |
| Compat matrix | GitHub Actions | PHP 8.2–8.5 × L12/L13 × Livewire lowest/latest × Tailwind 4.1/latest |

**Before/after**: Phase 0 runs the same PHP + browser suites on `2.x` (Livewire 3) to generate baselines; every v3 phase must keep them green (differences only where intentionally re-baselined in the PR, with screenshots attached).

**Critical regression areas**: Modal/Drawer binding, Select (largest component, `$wire.set`), Toast (server + client paths), Table (search/sort/pagination), Markdown (3rd-party editor, uploads), dark mode, class-override merging.

---

## 9. Release strategy

| Stage | Entry gate | Contents |
|---|---|---|
| `v3.0.0-alpha.1` | Phases 0–2 merged, CI green | Livewire 4 compat; call for testers |
| `v3.0.0-beta.1` | Phases 3–4 merged, visual diffs reviewed | API frozen; installer rewritten |
| `v3.0.0-rc.1` | Phase 5 merged; docs + UPGRADE.md complete; tested in 2 real apps (fresh L13 starter kit + an upgraded 2.x app) | bug fixes only |
| `v3.0.0` | ≥1 week on RC with no P1/P2; matrix green | tag from `3.x`, make `3.x` default branch |

Checkpoints: no phase merges with red matrix; no un-reviewed visual diffs; each breaking change has an UPGRADE.md entry in the same PR.

**Communication**: GitHub release notes per pre-release, pinned Discussion/Discord announcement, docs site version switcher (2.x/3.x), `2.x` support policy (security fixes until e.g. 2027-03).

**CHANGELOG.md structure** (Keep a Changelog): `## [3.0.0] – date` → *Requirements* · *Breaking* · *Added* · *Changed* · *Deprecated* · *Fixed* · *Security*.

**UPGRADE.md structure**: 1) Requirements & estimated time 2) Upgrade Livewire 3→4 in your app first (link official guide) 3) `composer require developermithu/tallcraftui:^3.0` 4) Update `app.css` (dark variant, theme colours, remove `tailwind.config.js` entry) — or re-run `php artisan install:tallcraftui` 5) Behaviour changes (`wire:model` modifiers, upload route config) 6) Deprecations & how to silence them 7) Troubleshooting (double Alpine, missing styles, dark mode).

---

## 10. Final roadmap

| # | Phase | Priority | Effort | Risk | Depends on |
|---|---|---|---|---|---|
| 0 | Baseline, workbench, CI, twMerge spike | Must | **L** | Med | — |
| 1 | Composer constraints, declare Livewire, drop lock | Must | S | Low | 0 |
| 2 | Livewire 4: `@entangle`→`x-modelable`, Toast interceptors, table hooks | Must | **L** | **High** | 1 |
| 3 | Alpine hygiene (namespaced toast, no globals, navigate-safe) | Should | M | Med | 2 |
| 4 | Tailwind 4.3: CSS entry, dark variant, class audit, installer | Must | M | Med | 0 (baselines) |
| 4b | Merger replacement (only if spike fails) | Must-if-failed | M | Med | 0 |
| 5 | Security: upload route, sort allowlist (deprecation) | Must | M | Low | 1 |
| 6 | Docs, UPGRADE, CHANGELOG, release | Must | M | Low | all |
| — | CSP-safe `Alpine.data` for Select/ColorPicker/Markdown | Nice | L | Med | 3 |
| — | Adopt v4 niceties (`data-loading` styling in Button, `wire:sort` table rows) | Nice | S–M | Low | 2 |

**High-risk tasks to front-load**: Phase 0 baselines (can't be recreated after migrating), twMerge spike, `x-modelable` prototype on Modal+Drawer (teleport) before converting the other six, Toast `interceptRequest` rewrite.

**Git strategy**
- Create `3.x` from `2.x`; keep `2.x` for fixes (cherry-pick security to both).
- One branch per phase: `v3/phase-0-test-harness`, `v3/phase-2-livewire4`, … → PR into `3.x`, squash-merge.
- Conventional commits (`feat(modal)!: bind via x-modelable`, `fix(toast): use interceptRequest`, `chore(deps)`), `!` marks breaking → feeds CHANGELOG.
- Tags `v3.0.0-alpha.N / beta.N / rc.N` on `3.x`; after GA switch default branch to `3.x`, update dependabot `target-branch`.
- This planning branch (`claude/v3-release-migration-plan-4a13ca`) carries the plan as `docs/v3-migration-plan.md` once approved.

---

## Execution after approval (this session)

1. Commit this plan as `docs/v3-migration-plan.md` on `claude/v3-release-migration-plan-4a13ca` and push (no code changes; no PR unless asked).

## Verification of the plan's claims
- Versions: Packagist p2 API / npm registry queried 2026-09-29 (laravel/framework v13.34.0, livewire v4.4.7, tailwindcss 4.3.3, alpinejs 3.17.4, tailwind-merge-laravel 1.4.0 requires L12+/PHP 8.2).
- Livewire 4 guidance: `docs/upgrading.md` and `docs/alpine.md` in `livewire/livewire` main (commit eee4431, 2026-09-28).
- Laravel 13: laravel.com/docs/13.x/upgrade. Tailwind 4.2/4.3: official release notes (4.2 deprecates `start-*`/`end-*`).
