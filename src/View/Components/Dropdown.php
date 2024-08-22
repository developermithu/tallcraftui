<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Helpers\ShadowHelper;
use Developermithu\Tallcraftui\Helpers\WidthHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public bool $persistent = false,
        public ?string $title = null,
        public ?string $icon = null,
        public bool $iconOutline = false,
        public bool $noTransition = false,
    ) {}

    public function widthClass(): string
    {
        return WidthHelper::getWidthClass('dropdown', $this->attributes);
    }

    public function dropdownPosition()
    {
        $defaultPosition = config('tallcraftui.dropdown.position');

        return match (true) {
            $this->attributes->get('top') => 'origin-top',
            $this->attributes->get('bottom') => 'origin-bottom',
            $this->attributes->get('left') => 'origin-top-left left-0',
            $this->attributes->get('right') => 'origin-top-right right-0',

            default => match ($defaultPosition) {
                'bottom' => 'origin-bottom',
                'left' => 'origin-top-left left-0',
                'right' => 'origin-top-right right-0',
                default => 'origin-top',
            },
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('dropdown', $this->attributes);
    }

    public function shadowClass(): string
    {
        return ShadowHelper::getShadowClass('dropdown', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div  
                x-data="{ open: false }" 
                
                @if(!$persistent)
                    @click.outside="open = false" 
                    x-on:keydown.escape.window="open = false"
                @endif
                
                @close.stop="open = false" 
                class="relative w-fit"
            >
                <div @click="open = ! open">
                    @isset($trigger)
                        {{ $trigger }}
                    @else 
                        <x-tc-button icon="chevron-down" flat circle />
                    @endisset
                </div>

                <div 
                    x-show="open" 
                    
                    @if(!$noTransition)
                        x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" 
                        x-transition:leave-end="opacity-0 scale-95"
                    @endif

                    @class([
                        "absolute bg-white dark:bg-gray-800 z-[999] mt-3",
                        $widthClass(),   
                        $roundedClass(), 
                        $shadowClass(), 
                        $dropdownPosition(), 
                    ])
                    
                    style="display: none;" 

                    @if(!$persistent)
                        @click="open = false" 
                    @endif
                >
                    <ul 
                       {{ $attributes->twMerge([
                                "ring-1 ring-black dark:ring-gray-700 ring-opacity-5 dark:bg-gray-800 dark:text-gray-100",
                                $roundedClass(),  
                                $title ? 'py-1' : '',
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
                    
                        {{ $content ?? $slot }}
                    </ul>
                </div>
            </div>
        HTML;
    }
}
