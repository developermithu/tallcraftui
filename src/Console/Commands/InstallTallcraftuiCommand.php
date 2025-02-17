<?php

namespace Developermithu\Tallcraftui\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallTallcraftuiCommand extends Command
{
    protected $signature = 'install:tallcraftui';

    protected $description = 'Install and Setup TallCraftUI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->publishAndImportTallcraftuiCSS();
        $this->setupTailwindConfig();

        // Rename component prefix if Jetstream or Breeze are detected
        $this->renameComponentPrefix();

        // Clear view cache
        Artisan::call('view:clear');

        $this->info("\n");
        $this->info('✅  Run `npm run dev` or `bun dev`');
        $this->info('🌟  Love TallCraftUI? give it a star: https://github.com/developermithu/tallcraftui');
    }

    /**
     * Setup Tailwind contents
     */
    private function setupTailwindConfig()
    {
        $tailwindJsPath = base_path('tailwind.config.js');
        $tailwindJs = File::get($tailwindJsPath);

        $configContent = str($tailwindJs);

        // Check if the path is already in the 'content' array to avoid duplicates
        if ($configContent->contains('developermithu/tallcraftui')) {
            return $this->warn('TallCraftUI is already installed.');
        }

        $this->info("\n".'Installing TallCraftUI...');

        // Locate the content array
        $contentArrayStart = $configContent->after('content:')->after('[');
        $contentArrayEnd = $contentArrayStart->before(']');

        // Trim the content array
        $newContentArray = $contentArrayEnd
            ->trim()
            ->explode(',')
            ->filter()
            ->map(fn ($item) => trim($item))
            ->push('"./vendor/developermithu/tallcraftui/src/**/*.php",') // Add the new path as the last item
            ->implode(",\n\t\t");

        // Format the content array with correct syntax and indentation
        $formattedContentArray = str("\n\t\t".$newContentArray."\n\t");

        // Replace the original content array with the updated one
        $updatedConfigContent = $configContent->replace($contentArrayEnd, $formattedContentArray);

        // Write the updated Tailwind config back to the file
        File::put($tailwindJsPath, $updatedConfigContent);

        $this->info('TallCraftUI installed successfully.');
    }

    public function renameComponentPrefix()
    {
        $composerJson = File::get(base_path('composer.json'));

        collect(['jetstream', 'breeze'])->each(function (string $target) use ($composerJson) {
            if (str($composerJson)->contains($target)) {

                Artisan::call('vendor:publish --tag=tallcraftui-config --force');

                $path = base_path('config/tallcraftui.php');
                $config = File::get($path);

                // Replaces existing prefix with 'tc-' in the tallcraftui.php configuration file.
                $contents = str($config)->replace("'prefix' => env('TALLCRAFTUI_PREFIX', '')", "'prefix' => env('TALLCRAFTUI_PREFIX', 'tc-')");

                File::put($path, $contents);

                $this->info("\n");
                $this->warn("Added 'tc-' prefix to TallCraftUI components to avoid conflicts with `$target` 🚨");
                $this->warn('* Usage Examples: <x-tc-button />');
                $this->warn('* See config/tallcraftui.php for details.');
            }
        });
    }

    protected function publishAndImportTallcraftuiCSS()
    {
        Artisan::call('vendor:publish --tag=tallcraftui-css --force');

        $appCssPath = resource_path('css/app.css');
        $importStatement = '@import "./tallcraftui.css";'.PHP_EOL.PHP_EOL;

        if (File::exists($appCssPath)) {
            // Read the current content of the app.css file
            $appCssContent = File::get($appCssPath);

            // Check if the tallcraftui.css is already present
            if (strpos($appCssContent, 'tallcraftui.css') === false) {
                $updatedContent = $importStatement.$appCssContent;

                File::put($appCssPath, $updatedContent);

                // $this->info('Imported `tallcraftui.css` to the top of `app.css`');
            } else {
                // $this->info('tallcraftui.css already exists in app.css');
                return;
            }
        } else {
            $this->error('`app.css` file not found.');
        }
    }
}
