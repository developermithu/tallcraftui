<?php

namespace Developermithu\Tallcraftui\Console\Commands;

use Developermithu\Tallcraftui\TallCraftUiServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class InstallTallcraftuiCommand extends Command
{
    protected $signature = 'install:tallcraftui';

    protected $description = 'Install and Setup TallCraftUI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->installTailwindFormsPlugin();
        $this->publishAndImportTallcraftuiAssets();

        // Use the 'tc-' prefix if the app already has components with the same names (e.g. Breeze / Jetstream)
        $this->renameComponentPrefix();

        // Clear view cache
        Artisan::call('view:clear');

        $this->info("\n");
        $this->info('✅  Run `npm run dev` or `bun dev`');
        $this->info('🌟  Love TallCraftUI? give it a star: https://github.com/developermithu/tallcraftui');
    }

    private function installTailwindFormsPlugin()
    {
        $packageJsonPath = base_path('package.json');

        if (! File::exists($packageJsonPath)) {
            $this->error('package.json not found.');

            return;
        }

        $packageJson = json_decode(File::get($packageJsonPath), true);

        // Check if @tailwindcss/forms is already installed in dependencies or devDependencies
        if (isset($packageJson['dependencies']['@tailwindcss/forms']) ||
            isset($packageJson['devDependencies']['@tailwindcss/forms'])) {
            return;
        }

        if (! $this->confirm('Would you like to install @tailwindcss/forms?', true)) {
            return;
        }

        $packageManagers = ['npm', 'yarn', 'pnpm', 'bun'];

        $packageManager = $this->choice(
            'Which package manager would you like to use?',
            $packageManagers,
            array_search($this->detectPackageManager(), $packageManagers)
        );

        $command = match ($packageManager) {
            'npm' => 'npm install -D @tailwindcss/forms',
            'yarn' => 'yarn add -D @tailwindcss/forms',
            'pnpm' => 'pnpm add -D @tailwindcss/forms',
            'bun' => 'bun add -D @tailwindcss/forms',
        };

        $this->info("\nInstalling @tailwindcss/forms using {$packageManager}...\n");

        $result = Process::path(base_path())
            ->timeout(300)
            ->run($command, fn (string $type, string $output) => $this->output->write($output));

        if ($result->successful()) {
            $this->info("\n@tailwindcss/forms installed successfully.\n");
        } else {
            $this->error("\nFailed to install @tailwindcss/forms. Please run `{$command}` manually.\n");
        }
    }

    private function detectPackageManager(): string
    {
        return match (true) {
            File::exists(base_path('bun.lock')), File::exists(base_path('bun.lockb')) => 'bun',
            File::exists(base_path('pnpm-lock.yaml')) => 'pnpm',
            File::exists(base_path('yarn.lock')) => 'yarn',
            default => 'npm',
        };
    }

    public function renameComponentPrefix()
    {
        $conflicts = $this->conflictingComponents();

        if (empty($conflicts)) {
            return;
        }

        $path = config_path('tallcraftui.php');

        // Don't overwrite a config the user has already published
        if (! File::exists($path)) {
            Artisan::call('vendor:publish --tag=tallcraftui-config');
        }

        $default = "'prefix' => env('TALLCRAFTUI_PREFIX', '')";
        $config = File::get($path);

        $this->info("\n");

        if (! str_contains($config, $default)) {
            $this->warn('Your app already has components named: '.implode(', ', $conflicts).' 🚨');
            $this->warn("* Set a component prefix (e.g. 'tc-') in config/tallcraftui.php to avoid conflicts.");

            return;
        }

        // Replaces existing prefix with 'tc-' in the tallcraftui.php configuration file.
        File::put($path, str_replace($default, "'prefix' => env('TALLCRAFTUI_PREFIX', 'tc-')", $config));

        $this->warn("Added 'tc-' prefix to TallCraftUI components to avoid conflicts with: ".implode(', ', $conflicts).' 🚨');
        $this->warn('* Usage Examples: <x-tc-button />');
        $this->warn('* See config/tallcraftui.php for details.');
    }

    /**
     * Component names already used by the app (or by Breeze / Jetstream, which publish them).
     *
     * @return array<int, string>
     */
    private function conflictingComponents(): array
    {
        $names = array_keys(TallCraftUiServiceProvider::components());

        $conflicts = array_filter($names, fn (string $name) => File::exists(resource_path("views/components/{$name}.blade.php"))
            || class_exists('App\\View\\Components\\'.Str::studly($name))
        );

        $composerJson = File::get(base_path('composer.json'));

        foreach (['laravel/jetstream', 'laravel/breeze'] as $kit) {
            if (str_contains($composerJson, $kit)) {
                $conflicts[] = $kit;
            }
        }

        return array_values($conflicts);
    }

    protected function publishAndImportTallcraftuiAssets()
    {
        Artisan::call('vendor:publish --tag=tallcraftui-css --force');

        $appCssPath = resource_path('css/app.css');

        if (! File::exists($appCssPath)) {
            $this->error('`app.css` file not found.');

            return;
        }

        $appCssContent = File::get($appCssPath);
        $statements = [];

        // Add each line only if missing, so re-running the installer is safe
        if (! str_contains($appCssContent, 'tallcraftui.css')) {
            $statements[] = "@import './tallcraftui.css';";
        }

        if (! str_contains($appCssContent, '@tailwindcss/forms')) {
            $statements[] = "@plugin '@tailwindcss/forms';";
        }

        // Class-based dark mode, used by <x-theme-toggle />
        if (! preg_match('/@custom-variant\s+dark\b/', $appCssContent)) {
            $statements[] = '@custom-variant dark (&:where(.dark, .dark *));';
        }

        if (empty($statements)) {
            $this->info('TallCraftUI already installed.');

            return;
        }

        File::put($appCssPath, $this->insertAfterImports($appCssContent, $statements));

        $this->info('TallCraftUI installed successfully.');
    }

    /**
     * Insert lines after the last top-level @import, since CSS requires @import rules to come first.
     */
    private function insertAfterImports(string $css, array $statements): string
    {
        $lines = preg_split('/\R/', $css);
        $lastImport = -1;

        foreach ($lines as $index => $line) {
            if (str_starts_with(trim($line), '@import')) {
                $lastImport = $index;
            }
        }

        if ($lastImport === -1) {
            return implode(PHP_EOL, [...$statements, '', $css]);
        }

        array_splice($lines, $lastImport + 1, 0, ['', ...$statements]);

        return implode(PHP_EOL, $lines);
    }
}
