# Upgrade Guide

## Upgrading from 2.x to 3.0

> **Beta:** 3.0 is currently in beta (`v3.0.0-beta.1`). Breaking changes may still be adjusted before the stable release, so don't use it in production yet. Please [report any issues](https://github.com/developermithu/tallcraftui/issues).

Estimated time: about 30 minutes for most apps.

3.0 keeps every component tag, prop, variant attribute and config key from 2.x. The breaking changes are the platform requirements, a few `wire:model` behaviors, and the hardened Markdown upload endpoint.

### Requirements

| | 2.x | 3.0 |
| --- | --- | --- |
| PHP | 8.1+ | **8.2+** |
| Laravel | 10, 11, 12 | **12, 13** |
| Livewire | 3 | **4** |
| Tailwind CSS | 4 | **4.1+** |
| Alpine.js | bundled with Livewire | bundled with Livewire |

`2.x` stays available for Livewire 3 apps and receives bug fixes only.

### 1. Upgrade your app to Livewire 4 first

Follow the official [Livewire 4 upgrade guide](https://livewire.laravel.com/docs/upgrading) and make sure your app works before upgrading TallCraftUI.

### 2. Update the package

While 3.0 is in beta, opt in to the pre-release:

```bash
composer require developermithu/tallcraftui:^3.0@beta
```

Once 3.0 is stable, use `composer require developermithu/tallcraftui:^3.0`.

### 3. Update your CSS

Republish the stylesheet. It now registers the component source path itself and ships default `primary` / `secondary` colors:

```bash
php artisan vendor:publish --tag=tallcraftui-css --force
```

Your `resources/css/app.css` should contain:

```css
@import 'tailwindcss';
@import './tallcraftui.css';
@plugin '@tailwindcss/forms';
@custom-variant dark (&:where(.dark, .dark *));
```

- The `@custom-variant dark` line enables class-based dark mode, which `<x-theme-toggle />` needs. Leave it out if you want dark mode to follow the operating system setting only.
- The `@source '../../vendor/developermithu/tallcraftui/src/**/*.php';` line in `app.css` is no longer needed, but it's harmless to keep.
- Defining `--color-primary` and `--color-secondary` in your own `@theme` is now optional. Your values always override the defaults (`#6d28d9` and `#a21caf`).
- If you still have a `tailwind.config.js` entry for TallCraftUI, you can remove it. The installer no longer edits that file.

Alternatively, re-run the installer. It only adds lines that are missing:

```bash
php artisan install:tallcraftui
```

### 4. Review behavior changes

#### Select and Color Picker follow `wire:model` modifiers

In 2.x, `<x-select>` and `<x-color-picker>` sent every change to the server immediately, whatever modifier you used. They now behave like any other `wire:model` input: the value syncs on the next request. Add `.live` if you need immediate updates:

```blade
<x-select wire:model.live="country" :options="$countries" />
```

#### Livewire 4 `wire:model` changes

These come from Livewire itself and apply to TallCraftUI inputs too:

- `.blur` and `.change` now also delay syncing the value in the browser. Use `wire:model.live.blur` for the Livewire 3 behavior.
- `wire:model` ignores `input` events bubbling up from child elements. Use `.deep` to restore the Livewire 3 behavior on your own wrappers.

#### Markdown image uploads

The upload endpoint used by `<x-markdown>` is stricter:

- Only the formats in `tallcraftui.upload.mimes` are accepted (jpg, jpeg, png, gif, webp, avif by default), up to `tallcraftui.upload.max_size` (2 MB by default). SVG files are rejected.
- Only disks listed in `tallcraftui.upload.disks` are accepted (`public` by default).
- The `folder` prop must be a plain path such as `markdown` or `posts/images`.
- The CSRF token is sent as a header instead of a query string parameter.

If you published the config, you don't need to change it: new keys are filled in automatically. To customize them, add this section to `config/tallcraftui.php`:

```php
'upload' => [
    'enabled' => env('TALLCRAFTUI_UPLOAD_ENABLED', true),
    'middleware' => ['web', 'auth'],
    'disks' => ['public'],
    'mimes' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'],
    'max_size' => 2048, // in kilobytes
],
```

Set `TALLCRAFTUI_UPLOAD_ENABLED=false` to remove the upload route entirely.

#### Markdown image cleanup (`HasMarkdownImages`)

Images are now only deleted when they're inside the model's markdown folder, so user-written markdown can't delete other files on the disk. If your `<x-markdown>` uses a `folder` other than `markdown`, set it on the model:

```php
protected string $markdownImageFolder = 'posts/images';
```

#### `WithTcTable`

- The trait's `updated()` hook is now `updatedWithTcTable()`, so it runs alongside your component's own `updated()`. If you aliased the trait method to avoid a conflict (for example `use WithTcTable { updated as tcUpdated; }`), remove the alias.
- Define `tcSortableColumns()` to whitelist the columns users can sort by. See [Deprecations](#5-deprecations).

#### Clickable table rows

`<x-tr href="...">` no longer navigates when you click a button, link or form control inside the row. Add `wire:navigate` to the row to navigate with Livewire, and Ctrl/Cmd-click opens the link in a new tab. `javascript:` URLs are ignored.

#### Toast helpers

The global functions `getPositionStyle`, `getPositionClasses`, `getAnimationClasses`, `getProgressBarColor` and `getProgressBarStyle` were removed from `window`. `window.toast()` and the `tallcraftui-toast` event are unchanged.

#### Class merging

TallCraftUI now depends on `gehrisandro/tailwind-merge-php` directly instead of `gehrisandro/tailwind-merge-laravel`, which blocked installs on Laravel 13 apps using Guzzle 8. The `twMerge`, `twMergeFor` and `withoutTwMergeClasses` attribute macros work as before, and a published `config/tailwind-merge.php` is still used.

If your own views use the `@twMerge` Blade directive or the global `twMerge()` helper, require the Laravel package yourself:

```bash
composer require gehrisandro/tailwind-merge-laravel
```

### 5. Deprecations

Sorting a `WithTcTable` component without a whitelist triggers an `E_USER_DEPRECATED` notice, which Laravel writes to your deprecations log channel. The whitelist will be required in 4.0. Add it to each table component:

```php
public function tcSortableColumns(): array
{
    return ['name', 'email', 'created_at', 'author.name'];
}
```

Sort columns outside the list are ignored.

### 6. Optional: avoid a dark mode flash

`<x-theme-toggle />` now applies the saved theme as soon as it renders. To apply it before the page first paints, add this to your layout's `<head>`:

```html
<script>
    if (localStorage.getItem('dark-mode') === 'true' ||
        (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
</script>
```

### Troubleshooting

**"Detected multiple instances of Alpine running"** or components that don't respond: Livewire 4 already includes Alpine and the plugins TallCraftUI uses. Remove `import Alpine from 'alpinejs'` and `Alpine.start()` from your `resources/js/app.js`.

**Components have no styles:** make sure `app.css` imports `./tallcraftui.css`, republish it with `--force`, and rebuild your assets with `npm run dev` or `npm run build`.

**Dark mode toggle does nothing:** add `@custom-variant dark (&:where(.dark, .dark *));` to `app.css`.

**Primary-colored components look violet:** that's the new default. Define `--color-primary` and `--color-secondary` in your own `@theme`.
