<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public bool $persistent = false,
    ) {}

    public function sizeClasses()
    {
        return match (true) {
            $this->attributes->get('w-20') => 'w-20',
            $this->attributes->get('w-24') => 'w-24',
            $this->attributes->get('w-28') => 'w-28',
            $this->attributes->get('w-32') => 'w-32',
            $this->attributes->get('w-36') => 'w-36',
            $this->attributes->get('w-40') => 'w-40',
            $this->attributes->get('w-44') => 'w-44',
            $this->attributes->get('w-48') => 'w-48',
            $this->attributes->get('w-52') => 'w-52',
            $this->attributes->get('w-56') => 'w-56',
            $this->attributes->get('w-60') => 'w-60',
            $this->attributes->get('w-64') => 'w-64',
            $this->attributes->get('w-72') => 'w-72',
            $this->attributes->get('w-80') => 'w-80',
            $this->attributes->get('w-96') => 'w-96',
            $this->attributes->get('w-full') => 'w-full',
            default => config('tallcraftui.dropdown.size', 'w-48'),
        };
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
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"

                    @class([
                        "absolute bg-white dark:bg-gray-800 z-[999] mt-3 shadow-lg",
                        $sizeClasses(),   
                        $roundedClass(), 
                        $dropdownPosition(), 
                    ])
                    
                    style="display: none;" 

                    @if(!$persistent)
                        @click="open = false" 
                    @endif
                >
                    <div 
                       {{ $attributes->twMerge([
                                "ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:text-gray-100",
                                $roundedClass(),    
                            ]) 
                        }}
                    >
                        {{ $content ?? $slot }}
                    </div>
                </div>
            </div>
        HTML;
    }
}
