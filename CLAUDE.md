# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

TallCraftUI is a Blade UI component library for the TALL stack (Laravel 10–12, Tailwind v4). Docs: https://tallcraftui.com.

## Branches

- `3.x` is the active development line. `1.x` and `2.x` are maintenance-only (bug fixes). Confirm the target branch before starting new feature work.

## Verification & formatting

- There is no test suite, CI, or static analysis. Changes are verified manually in a local Herd Laravel app that requires this package via a composer path repository — tell the user what to check there (variants, dark mode, custom prefix).
- Run Pint only on files you changed (`vendor/bin/pint path/to/File.php`), never repo-wide — much of the existing code isn't Pint-clean and repo-wide runs create noisy diffs. Requires `composer install` first.
- Docs live in a separate repo. When a component's props, variants, or behavior change, remind the user to update the docs.

## Architecture & conventions

- Components are class components in `src/View/Components/` with **inline nowdoc templates** (`return <<<'HTML' ... HTML;` in `render()`) — there are no Blade view files. Don't create `resources/views`.
- Registration is a name => class map in `src/TallCraftUiServiceProvider.php`, prefixed with `config('tallcraftui.prefix')` (default `''`, `tc-` when Breeze/Jetstream is detected by the installer).
- When nesting components inside templates, use the fixed `tc-` aliases (`<x-tc-icon>`, `<x-tc-button>`, `<x-tc-label>`, `<x-tc-hint>`, `<x-tc-badge>`, `<x-tc-native-select>`, `<x-tc-input>`, `<x-tc-spinner>`) so they work regardless of the user's prefix. If you nest a component that has no alias, add one.
- Class merging uses tailwind-merge: `$attributes->withoutTwMergeClasses()->except($colorAttributes)->twMerge([...])`, and `$attributes->twMergeFor('icon', ...)` for sub-elements.
- Variants (colors, `outline`, sizes, `rounded-*`) are **boolean attributes** read via `$this->attributes->get('red')` in `match (true)` chains, living in `src/Traits/Colors/Has*Colors.php` and `src/Traits/Sizes/Has*Sizes.php`. Variant attributes must be stripped from output via `except($colorAttributes)` (`HasColorAttributes`).
- Per-component defaults (border-radius, size, shadow, position…) live in `config/tallcraftui.php` keyed by component name, using Enum `->value`s from `src/Enums/`; helpers in `src/Helpers/` (e.g. `BorderRadiusHelper::getRoundedClass('badge', $attributes)`) fall back to these.
- Use theme colors `primary`/`secondary` (user-defined in their Tailwind theme) and give every color class a `dark:` counterpart.
- Translate user-facing labels: `__($label)`.
- Host apps must have Tailwind scan `vendor/developermithu/tallcraftui/src/**/*.php`, since templates live in PHP files — keep class strings complete (no dynamic string concatenation of Tailwind classes).
