<?php

namespace Developermithu\Tallcraftui\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallTallcraftuiCommand extends Command
{
    protected $signature = 'install:tallcraftui';

    protected $description = 'Install and Setup TallcraftUI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setupTailwindConfig();

        // Rename component prefix if Jetstream or Breeze are detected
        $this->renameComponentPrefix();

        // Clear view cache
        Artisan::call('view:clear');

        $this->info("\n");
        $this->info("✅  Run `npm run dev` or `yarn dev`");
        $this->info("🌟  Give it a star: https://github.com/developermithu/tallcraftui");
    }

    private function setupTailwindConfig()
    {
        /**
         * Setup Tailwind contents
         */
        $tailwindJsPath = base_path('tailwind.config.js');
        $tailwindJs = File::get($tailwindJsPath);

        $originalContents = str($tailwindJs)
            ->after('contents')
            ->after('[')
            ->before(']');

        if ($originalContents->contains('developermithu/tallcraftui')) {
            return $this->warn('TallcraftUI already installed.');
        }

        $this->info("\n" . 'Installing TallcraftUI...');

        $contents = $originalContents
            ->squish()
            ->trim()
            ->remove(' ')
            ->explode(',')
            ->add('"./vendor/developermithu/tallcraftui/src/View/Components/**/*.php",')
            ->filter()
            ->implode(', ');

        $contents = str($contents)
            ->prepend("\n\t\t")
            ->replace(',', ",\n\t\t")
            ->append("\r\n\t");

        $contents = str($tailwindJs)->replace($originalContents, $contents);

        File::put($tailwindJsPath, $contents);

        $this->info('TallcraftUI installed successfully.');
    }

    public function renameComponentPrefix()
    {
        $composerJson = File::get(base_path("composer.json"));

        collect(['jetstream', 'breeze'])->each(function (string $target) use ($composerJson) {
            if (str($composerJson)->contains($target)) {

                Artisan::call('vendor:publish --force --tag tallcraftui-config');

                $path = base_path('config/tallcraftui.php');
                $config = File::get($path);

                // Replaces existing prefix with 'tall-' in the tallcraftui.php configuration file.
                $contents = str($config)->replace("'prefix' => ''", "'prefix' => 'tall-'");
                File::put($path, $contents);

                $this->info("\n");
                $this->warn("Added 'tall-' prefix to tallcraftuiUI components to avoid conflicts with `$target` 🚨");
                $this->warn("* Examples: <x-tall-button />, <x-tall-input />");
                $this->warn("* See config/tallcraftui.php for details.");
            }
        });
    }
}
