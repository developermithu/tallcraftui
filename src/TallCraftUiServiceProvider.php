<?php

namespace Developermithu\Tallcraftui;

use Developermithu\Tallcraftui\Console\Commands\InstallTallcraftuiCommand;
use Developermithu\Tallcraftui\View\Components\Accordion\Accordion;
use Developermithu\Tallcraftui\View\Components\Accordion\AccordionItem;
use Developermithu\Tallcraftui\View\Components\Alert;
use Developermithu\Tallcraftui\View\Components\Avatar;
use Developermithu\Tallcraftui\View\Components\Avatars;
use Developermithu\Tallcraftui\View\Components\Badge;
use Developermithu\Tallcraftui\View\Components\Breadcrumb;
use Developermithu\Tallcraftui\View\Components\BreadcrumbItem;
use Developermithu\Tallcraftui\View\Components\Button;
use Developermithu\Tallcraftui\View\Components\Card\Card;
use Developermithu\Tallcraftui\View\Components\Card\CardContent;
use Developermithu\Tallcraftui\View\Components\Card\CardFigure;
use Developermithu\Tallcraftui\View\Components\Card\CardFooter;
use Developermithu\Tallcraftui\View\Components\Card\CardHeader;
use Developermithu\Tallcraftui\View\Components\Checkbox;
use Developermithu\Tallcraftui\View\Components\Clipboard;
use Developermithu\Tallcraftui\View\Components\ColorPicker;
use Developermithu\Tallcraftui\View\Components\Drawer;
use Developermithu\Tallcraftui\View\Components\Dropdown;
use Developermithu\Tallcraftui\View\Components\DropdownItem;
use Developermithu\Tallcraftui\View\Components\Hint;
use Developermithu\Tallcraftui\View\Components\Icon;
use Developermithu\Tallcraftui\View\Components\Input;
use Developermithu\Tallcraftui\View\Components\Label;
use Developermithu\Tallcraftui\View\Components\Markdown;
use Developermithu\Tallcraftui\View\Components\Menu;
use Developermithu\Tallcraftui\View\Components\MenuItem;
use Developermithu\Tallcraftui\View\Components\Modal;
use Developermithu\Tallcraftui\View\Components\Password;
use Developermithu\Tallcraftui\View\Components\Progress;
use Developermithu\Tallcraftui\View\Components\ProgressRadial;
use Developermithu\Tallcraftui\View\Components\Radio;
use Developermithu\Tallcraftui\View\Components\Range;
use Developermithu\Tallcraftui\View\Components\Rating;
use Developermithu\Tallcraftui\View\Components\Select;
use Developermithu\Tallcraftui\View\Components\Separator;
use Developermithu\Tallcraftui\View\Components\Spinner;
use Developermithu\Tallcraftui\View\Components\Stat;
use Developermithu\Tallcraftui\View\Components\Tab\Tab;
use Developermithu\Tallcraftui\View\Components\Tab\TabContent;
use Developermithu\Tallcraftui\View\Components\Tab\TabItem;
use Developermithu\Tallcraftui\View\Components\Table\Index;
use Developermithu\Tallcraftui\View\Components\Table\NotFound;
use Developermithu\Tallcraftui\View\Components\Table\Td;
use Developermithu\Tallcraftui\View\Components\Table\Th;
use Developermithu\Tallcraftui\View\Components\Table\Tr;
use Developermithu\Tallcraftui\View\Components\Textarea;
use Developermithu\Tallcraftui\View\Components\Toast;
use Developermithu\Tallcraftui\View\Components\Toggle;
use Developermithu\Tallcraftui\View\Components\Tooltip;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TallCraftUiServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->registerComponents();

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->publishes([
            __DIR__.'/../config/tallcraftui.php' => config_path('tallcraftui.php'),
        ], 'tallcraftui-config');

        $this->publishes([
            __DIR__.'/../src/resources/css/tallcraftui.css' => resource_path('css/tallcraftui.css'),
        ], 'tallcraftui-css');

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
            'drawer' => Drawer::class,
            'dropdown' => Dropdown::class,
            'dropdown-item' => DropdownItem::class,
            'stat' => Stat::class,
            'menu' => Menu::class,
            'menu-item' => MenuItem::class,
            'separator' => Separator::class,
            'spinner' => Spinner::class,
            'password' => Password::class,

            'tab' => Tab::class,
            'tab-item' => TabItem::class,
            'tab-content' => TabContent::class,

            'accordion' => Accordion::class,
            'accordion-item' => AccordionItem::class,

            'color-picker' => ColorPicker::class,

            'card' => Card::class,
            'card-figure' => CardFigure::class,
            'card-header' => CardHeader::class,
            'card-content' => CardContent::class,
            'card-footer' => CardFooter::class,

            // Table Components
            'table' => Index::class,
            'th' => Th::class,
            'td' => Td::class,
            'tr' => Tr::class,
            'not-found' => NotFound::class,

            'tooltip' => Tooltip::class,
            'range' => Range::class,
            'clipboard' => Clipboard::class,
            'avatar' => Avatar::class,
            'avatars' => Avatars::class,
            'toast' => Toast::class,
            'rating' => Rating::class,
            'markdown' => Markdown::class,
            'progress' => Progress::class,
            'progress-radial' => ProgressRadial::class,
        ];

        foreach ($components as $name => $class) {
            Blade::component($prefix.$name, $class);
        }

        // TallCraftUI internal components
        Blade::component('tc-icon', Icon::class);
        Blade::component('tc-button', Button::class);
        Blade::component('tc-label', Label::class);
        Blade::component('tc-hint', Hint::class);
        Blade::component('tc-badge', Badge::class);
        Blade::component('tc-select', Select::class);
        Blade::component('tc-input', Input::class);
        Blade::component('tc-spinner', Spinner::class);
    }
}
