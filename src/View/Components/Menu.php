<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Helpers\ShadowHelper;
use Developermithu\Tallcraftui\Helpers\WidthHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public bool $iconOutline = false,
    ) {}

    public function widthClass(): string
    {
        return WidthHelper::getWidthClass('menu', $this->attributes);
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('menu', $this->attributes);
    }

    public function shadowClass(): string
    {
        return ShadowHelper::getShadowClass('menu', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <ul {{ $attributes->withoutTwMergeClasses()->twMerge([
                        "z-10 py-1 mt-2 bg-white dark:bg-gray-800 ring-1 ring-black dark:ring-gray-700 ring-opacity-5 focus:outline-none",
                        $widthClass(),
                        $roundedClass(),    
                        $shadowClass(),    
                    ]) 
                }}
            >
                @if($title)
                    <li {{ $attributes->twMergeFor("title", "flex items-center px-4 pt-1 pb-2 text-xs font-medium text-gray-400 dark:text-gray-500 uppercase gap-x-2") }}>
                        @if($icon)
                            <x-tc-icon 
                                :name="$icon" 
                                :solid="$iconOutline ? false : true" 
                                {{ $attributes->twMergeFor('icon', 'size-4') }} 
                            />
                        @endif

                        {{ __($title)}}
                    </li>
                @endif
            
                {{ $slot }}
            </ul>
        HTML;
    }
}
