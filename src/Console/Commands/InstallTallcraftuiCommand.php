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
        $this->installTailwindFormsPlugin();
        $this->publishAndImportTallcraftuiAssets();
        $this->setupTailwindConfig();
    
        // Rename component prefix if Jetstream or Breeze are detected
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
        
        if (!File::exists($packageJsonPath)) {
            $this->error('package.json not found.');
            return;
        }
    
        $packageJson = json_decode(File::get($packageJsonPath), true);
        
        // Check if @tailwindcss/forms is already installed in dependencies or devDependencies
        if (isset($packageJson['dependencies']['@tailwindcss/forms']) || 
            isset($packageJson['devDependencies']['@tailwindcss/forms'])) {
            return;
        }
    
        if (!$this->confirm('Would you like to install @tailwindcss/forms?', true)) {
            return;
        }
    
        $packageManager = $this->choice(
            'Which package manager would you like to use?',
            ['npm', 'yarn', 'pnpm', 'bun'],
            0
        );
    
        $command = match ($packageManager) {
            'npm' => 'npm install -D @tailwindcss/forms',
            'yarn' => 'yarn add -D @tailwindcss/forms',
            'pnpm' => 'pnpm add -D @tailwindcss/forms',
            'bun' => 'bun add -D @tailwindcss/forms',
        };
    
        $this->info("\nInstalling @tailwindcss/forms using {$packageManager}...\n");
        
        $process = shell_exec($command);
        
        if ($process !== null) {
            $this->info("\n@tailwindcss/forms installed successfully.\n");
        } else {
            $this->error("\nFailed to install @tailwindcss/forms. Please install it manually.\n");
        }
    }

    /**
     * Setup Tailwind contents
     */
    private function setupTailwindConfig()
    {
        $tailwindJsPath = base_path('tailwind.config.js');

        // Skip if tailwind.config.js doesn't exist
        if (!File::exists($tailwindJsPath)) {
            return;
        }

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

    protected function publishAndImportTallcraftuiAssets()
    {
        Artisan::call('vendor:publish --tag=tallcraftui-css --force');
    
        $appCssPath = resource_path('css/app.css');
        $importStatements = [];
        
        if (File::exists($appCssPath)) {
            $appCssContent = File::get($appCssPath);
            
            // Check each import separately and add only if missing
            if (strpos($appCssContent, 'tallcraftui.css') === false) {
                $importStatements[] = "@import './tallcraftui.css';";
            }

            if (strpos($appCssContent, '@tailwindcss/forms') === false) {
                $importStatements[] = "@plugin '@tailwindcss/forms';";
            }
            
            if (strpos($appCssContent, 'developermithu/tallcraftui') === false) {
                $importStatements[] = "@source '../../vendor/developermithu/tallcraftui/src/**/*.php';";
            }
            
            if (!empty($importStatements)) {
                // Add new line after imports if any were added
                $importStatements[] = '';
                $updatedContent = implode(PHP_EOL, $importStatements) . PHP_EOL . $appCssContent;
                File::put($appCssPath, $updatedContent);
                $this->info('TallCraftUI installed successfully.');
            } else {
                $this->info('TallCraftUI already installed.');
            }
        } else {
            $this->error('`app.css` file not found.');
        }
    }
}
