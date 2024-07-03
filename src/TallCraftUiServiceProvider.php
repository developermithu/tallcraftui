<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\View\Components\Button;
use Developermithu\Tallcraftui\View\Components\Icon;
use Developermithu\Tallcraftui\View\Components\Input;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TallCraftUiServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(): void
    {
        // No matter if components has custom prefix or not,
        // we also register bellow alias to avoid naming collision,
        // because they are used inside some TallCraft's components itself.

        Blade::component('tall-button', Button::class);
        Blade::component('tall-input', Input::class);
        Blade::component('tall-icon', Icon::class);

        Blade::component('icon', Icon::class);
    }
}
