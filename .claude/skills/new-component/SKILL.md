---
name: new-component
description: Add a new TallCraftUI Blade component end-to-end (class with inline template, color/size traits, config defaults, provider registration, docs reminder). Use when creating a new component or variant family.
---

Add the component named in `$ARGUMENTS` (kebab-case, e.g. `chip`). Use `src/View/Components/Badge.php` and its traits as the reference implementation.

1. **Class** — `src/View/Components/<StudlyName>.php` (or a subfolder like `Card/` for compound components), extending `Illuminate\View\Component`.
   - Constructor props for real data (`label`, `icon`, `iconLeft`, `iconRight`, …). Variants are NOT props — they're boolean attributes.
   - `render()` returns an inline nowdoc `<<<'HTML' ... HTML;` template. No Blade view files.
   - Root element: `$attributes->withoutTwMergeClasses()->except($colorAttributes)->twMerge([...base, $getSizeClasses(), $getColorClasses(), $roundedClass()])`.
   - Sub-elements: `$attributes->twMergeFor('icon', ...)`.
   - Nest other components via `tc-` aliases (`<x-tc-icon>` etc.).
   - Labels rendered as `{{ $label ? __($label) : $slot }}`.

2. **Traits** (only if the component has variants):
   - `src/Traits/Colors/Has<Name>Colors.php` — `use HasColorAttributes;`, `match (true)` on `$this->attributes->get('<color>')`. Every color class needs a `dark:` variant; default to `primary`.
   - `src/Traits/Sizes/Has<Name>Sizes.php` — same pattern for `xs`/`sm`/`md`/`lg`/`xl`.
   - Keep all Tailwind class strings literal (Tailwind scans these PHP files).

3. **Config defaults** — add `'<name>' => [...]` to `config/tallcraftui.php` using Enum `->value`s from `src/Enums/`, and read them through the matching helper in `src/Helpers/` (e.g. `BorderRadiusHelper::getRoundedClass('<name>', $this->attributes)`).

4. **Register** — import the class and add `'<name>' => <Class>::class` to the `$components` map in `src/TallCraftUiServiceProvider.php`. If other components will nest it, also add `Blade::component('tc-<name>', <Class>::class);`.

5. **Format** — `vendor/bin/pint` on the new/changed files only.

6. **Hand-off** — give the user a Blade snippet exercising the default, a couple of color/size variants, `dark` mode, and a custom `class`, to try in their local Herd app. Remind them to add a docs page in the separate docs repo.
