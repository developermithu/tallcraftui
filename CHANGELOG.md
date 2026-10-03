# Changelog

All notable changes to TallCraftUI are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0] - Unreleased

See [UPGRADE.md](UPGRADE.md) for step-by-step upgrade instructions.

### Requirements

- PHP 8.2+, Laravel 12 or 13, Livewire 4 and Tailwind CSS 4.1+.

### Breaking

- Dropped support for Laravel 10 and 11, Livewire 3 and PHP 8.1.
- `<x-select>` and `<x-color-picker>` follow `wire:model` modifiers instead of always syncing immediately. Use `wire:model.live` for the previous behavior.
- The Markdown upload endpoint validates file type and size, only accepts disks listed in `tallcraftui.upload.disks`, rejects folder names containing `..` or a leading slash, and expects the CSRF token in a header.
- `HasMarkdownImages` only deletes images inside the model's markdown folder (`$markdownImageFolder`, default `markdown`).
- `WithTcTable::updated()` was renamed to `updatedWithTcTable()`.
- `<x-tr href>` no longer navigates when clicking buttons, links or form controls inside the row.
- Removed the global Toast helper functions from `window` (`window.toast()` is unchanged).
- Replaced the `gehrisandro/tailwind-merge-laravel` dependency with `gehrisandro/tailwind-merge-php`. The `@twMerge` directive and `twMerge()` helper are no longer installed.
- The installer no longer edits `tailwind.config.js`.

### Added

- `upload` config section: `enabled`, `middleware`, `disks`, `mimes` and `max_size`.
- `tcSortableColumns()` whitelist for `WithTcTable` sorting.
- `wire:navigate` and Ctrl/Cmd-click support on `<x-tr href>`.
- Default `primary` and `secondary` theme colors, and the component `@source` path, in `tallcraftui.css`.
- `tallcraftui-theme-changed` window event, which keeps several `<x-theme-toggle />` instances in sync.
- `window.TallCraftUI` namespace for shared JavaScript.
- `TallCraftUiServiceProvider::components()` returns the component name map.

### Changed

- `Modal`, `Drawer`, `Tab`, `Accordion`, `Rating`, `Password`, `ColorPicker`, `Markdown` and `Select` bind with `x-modelable` instead of `@entangle`.
- Toast error handling uses `Livewire.interceptRequest`.
- The installer adds missing `app.css` lines after existing `@import` rules, adds the class-based dark variant, installs packages with the Process facade, detects the package manager from the lockfile, and picks the `tc-` prefix when the app already has components with the same names.
- `<x-select>` uses `outline-hidden` instead of `outline-none`.

### Deprecated

- Sorting a `WithTcTable` component without `tcSortableColumns()`. It will be required in 4.0.

### Fixed

- `<x-password>` dropped `wire:model` modifiers such as `.live`.
- Two-way bound components failed without `wire:model` or outside a Livewire component.
- `<x-select>` didn't update when the bound property changed on the server.
- `<x-markdown>` initialized the editor twice when loading a value.
- Error toasts didn't work when the toast first rendered on a `wire:navigate` page.
- `WithTcTable` didn't run its update hook when the component defined its own `updated()`.
- Installing on Laravel 13 apps that use Guzzle 8.
- Dark mode flashed light before Alpine started, and wasn't reapplied after `wire:navigate`.
- The installer duplicated lines when re-run and overwrote a published config.
- New config keys were missing when using an older published config.
- Removed the Tailwind v3-only `bg-opacity-90` class from `<x-tooltip>`.

### Security

- Markdown uploads: restricted file types (no SVG or HTML), size limit, disk allowlist and folder validation.
- `HasMarkdownImages` could delete any file on the disk through user-written markdown.
- `WithTcTable` passed the client-controlled `sortCol` to the query, including relation names called as model methods.
- `<x-tr href>` rendered the URL into an inline `onclick`, allowing `javascript:` URLs.
