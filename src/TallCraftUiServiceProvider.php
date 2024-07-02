<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\View\Components\Button;
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
        Blade::component('tall-button', Button::class);
        Blade::component('tall-input', Input::class);
    }
}
