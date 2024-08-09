<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\Console\Commands\InstallTallcraftuiCommand;
use Developermithu\Tallcraftui\View\Components\{
    Alert,
    Badge,
    Breadcrumb,
    BreadcrumbItem,
    Button,
    Checkbox,
    Dropdown,
    DropdownItem,
    Hint,
    Icon,
    Input,
    Label,
    Modal,
    Radio,
    Select,
    Textarea,
    Toggle
};
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TallCraftUiServiceProvider extends ServiceProvider
{
    public function register(): void {}

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

        $components = [
            'button' => Button::class,
            'badge' => Badge::class,
            'input' => Input::class,
            'icon' => Icon::class,
            'textarea' => Textarea::class,
            'toggle' => Toggle::class,
            'select' => Select::class,
            'checkbox' => Checkbox::class,
            'radio' => Radio::class,
            'alert' => Alert::class,
            'breadcrumb' => Breadcrumb::class,
            'breadcrumb-item' => BreadcrumbItem::class,
            'modal' => Modal::class,
            'dropdown' => Dropdown::class,
            'dropdown-item' => DropdownItem::class,
        ];

        foreach ($components as $name => $class) {
            Blade::component($prefix . $name, $class);
        }

        // TallCraftUI internal components
        Blade::component('tc-icon', Icon::class);
        Blade::component('tc-button', Button::class);
        Blade::component('tc-label', Label::class);
        Blade::component('tc-hint', Hint::class);
    }
}
