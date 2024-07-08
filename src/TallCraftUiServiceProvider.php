<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\View\Components\Button;
use Developermithu\Tallcraftui\View\Components\Icon;
use Developermithu\Tallcraftui\View\Components\Input;
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
    }

    private function registerComponents(): void
    {
        $prefix = config('tallcraftui.prefix');

        Blade::component($prefix . 'button', Button::class);
        Blade::component($prefix . 'input', Input::class);
        Blade::component($prefix . 'icon', Icon::class);
    }
}
