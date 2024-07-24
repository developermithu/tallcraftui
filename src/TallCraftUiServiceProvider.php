<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\Console\Commands\InstallTallcraftuiCommand;
use Developermithu\Tallcraftui\View\Components\Alert;
use Developermithu\Tallcraftui\View\Components\Breadcrumb;
use Developermithu\Tallcraftui\View\Components\BreadcrumbItem;
use Developermithu\Tallcraftui\View\Components\Button;
use Developermithu\Tallcraftui\View\Components\Checkbox;
use Developermithu\Tallcraftui\View\Components\Hint;
use Developermithu\Tallcraftui\View\Components\Icon;
use Developermithu\Tallcraftui\View\Components\Input;
use Developermithu\Tallcraftui\View\Components\Label;
use Developermithu\Tallcraftui\View\Components\Modal;
use Developermithu\Tallcraftui\View\Components\Radio;
use Developermithu\Tallcraftui\View\Components\Select;
use Developermithu\Tallcraftui\View\Components\Textarea;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TallCraftUiServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->registerComponents();

        $this->publishes([
            __DIR__.'/../config/tallcraftui.php' => config_path('tallcraftui.php'),
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

        Blade::component($prefix.'button', Button::class);
        Blade::component($prefix.'input', Input::class);
        Blade::component($prefix.'icon', Icon::class);
        Blade::component($prefix.'textarea', Textarea::class);
        Blade::component($prefix.'select', Select::class);
        Blade::component($prefix.'checkbox', Checkbox::class);
        Blade::component($prefix.'radio', Radio::class);
        Blade::component($prefix.'alert', Alert::class);
        Blade::component($prefix.'breadcrumb', Breadcrumb::class);
        Blade::component($prefix.'breadcrumb-item', BreadcrumbItem::class);
        Blade::component($prefix.'modal', Modal::class);

        // TallCraftUI internal components
        Blade::component('tall-label', Label::class);
        Blade::component('tall-hint', Hint::class);
    }
}
