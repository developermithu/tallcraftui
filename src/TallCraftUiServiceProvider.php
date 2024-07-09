<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\Console\Commands\InstallTallcraftuiCommand;
use Developermithu\Tallcraftui\View\Components\Button;
use Developermithu\Tallcraftui\View\Components\Icon;
use Developermithu\Tallcraftui\View\Components\Input;
use Developermithu\Tallcraftui\View\Components\Select;
use Developermithu\Tallcraftui\View\Components\Textarea;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TallCraftUiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->registerComponents();

        $this->publishes([
            __DIR__ . '/../config/tallcraftui.php' => config_path('tallcraftui.php'),
        ], 'tallcraftui-config');

        // Register the application's commands.
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallTallcraftuiCommand::class,
            ]);
        }
    }

    private function registerComponents(): void
    {
        $prefix = config('tallcraftui.prefix');

        Blade::component($prefix . 'button', Button::class);
        Blade::component($prefix . 'input', Input::class);
        Blade::component($prefix . 'icon', Icon::class);
        Blade::component($prefix . 'textarea', Textarea::class);
        Blade::component($prefix . 'select', Select::class);
    }
}
