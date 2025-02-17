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

    public function position()
    {
        $defaultPosition = config('tallcraftui.dropdown.position', 'bottom-end');

        $basePosition = match (true) {
            $this->attributes->get('top') => 'top',
            $this->attributes->get('top-start') => 'top-start',
            $this->attributes->get('top-end') => 'top-end',
            $this->attributes->get('bottom') => 'bottom',
            $this->attributes->get('bottom-start') => 'bottom-start',
            $this->attributes->get('bottom-end') => 'bottom-end',
            $this->attributes->get('left') => 'left',
            $this->attributes->get('left-start') => 'left-start',
            $this->attributes->get('left-end') => 'left-end',
            $this->attributes->get('right') => 'right',
            $this->attributes->get('right-start') => 'right-start',
            $this->attributes->get('right-end') => 'right-end',
            default => $defaultPosition,
        };

        return match ($basePosition) {
            'top' => 'x-anchor.top.offset.14',
            'top-start' => 'x-anchor.top-start.offset.14',
            'top-end' => 'x-anchor.top-end.offset.14',
            'bottom' => 'x-anchor.bottom.offset.14',
            'bottom-start' => 'x-anchor.bottom-start.offset.14',
            'bottom-end' => 'x-anchor.bottom-end.offset.14',
            'left' => 'x-anchor.left.offset.14',
            'left-start' => 'x-anchor.left-start.offset.14',
            'left-end' => 'x-anchor.left-end.offset.14',
            'right' => 'x-anchor.right.offset.14',
            'right-start' => 'x-anchor.right-start.offset.14',
            'right-end' => 'x-anchor.right-end.offset.14',
            default => 'x-anchor.bottom-end.offset.14',
        };
    }

    public function animation()
    {
        $defaultAnimation = config('tallcraftui.dropdown.animation', 'fade');

        return match (true) {
            $this->attributes->get('fade') => 'fade',
            $this->attributes->get('slide') => 'slide',
            $this->attributes->get('flip') => 'flip',
            $this->attributes->get('rotate') => 'rotate',
            default => $defaultAnimation,
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
                <div @click="open = ! open" x-ref="trigger">
                    @isset($trigger)
                        {{ $trigger }}
                    @else 
                        <x-tc-button icon="chevron-down" flat circle />
                    @endisset
                </div>

                <div 
                    x-show="open"
                    {{ $position() }}="$refs.trigger"
                    
                    @if(!$noTransition)
                        @if($animation() === 'slide')
                            @if(strpos($position(), 'top') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-4"
                            @elseif(strpos($position(), 'bottom') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-4"
                            @elseif(strpos($position(), 'left') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 -translate-x-4"
                            @elseif(strpos($position(), 'right') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 translate-x-4"
                                x-transition:enter-end="opacity-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 translate-x-0"
                                x-transition:leave-end="opacity-0 translate-x-4"
                            @endif
                        
                        @elseif($animation() === 'flip')
                            @if(strpos($position(), 'top') !== false || strpos($position(), 'bottom') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 scale-75 rotate-x-180"
                                x-transition:enter-end="opacity-100 scale-100 rotate-x-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100 rotate-x-0"
                                x-transition:leave-end="opacity-0 scale-75 rotate-x-180"
                            @elseif(strpos($position(), 'left') !== false || strpos($position(), 'right') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 scale-75 rotate-y-180"
                                x-transition:enter-end="opacity-100 scale-100 rotate-y-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100 rotate-y-0"
                                x-transition:leave-end="opacity-0 scale-75 rotate-y-180"
                            @endif
                        
                        @elseif($animation() === 'rotate')
                            @if(strpos($position(), 'top') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 rotate-12"
                                x-transition:enter-end="opacity-100 rotate-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 rotate-0"
                                x-transition:leave-end="opacity-0 rotate-12"
                            @elseif(strpos($position(), 'bottom') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 rotate-12"
                                x-transition:enter-end="opacity-100 rotate-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 rotate-0"
                                x-transition:leave-end="opacity-0 rotate-12"
                            @elseif(strpos($position(), 'left') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 -rotate-12"
                                x-transition:enter-end="opacity-100 rotate-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 rotate-0"
                                x-transition:leave-end="opacity-0 -rotate-12"
                            @elseif(strpos($position(), 'right') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 rotate-12"
                                x-transition:enter-end="opacity-100 rotate-0"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 rotate-0"
                                x-transition:leave-end="opacity-0 rotate-12"
                            @endif

                        @else
                            @if(strpos($position(), 'top') !== false || strpos($position(), 'bottom') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                            @elseif(strpos($position(), 'left') !== false || strpos($position(), 'right') !== false)
                                x-transition:enter="transition ease-out duration-200 transform"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75 transform"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                            @endif
        
                        @endif
                    @endif

                    @class([
                        "absolute bg-white dark:bg-gray-800 z-[999]",
                        $widthClass(),   
                        $roundedClass(), 
                        $shadowClass(), 
                    ])
                    
                    style="display: none;" 

                    @if(!$persistent)
                        @click="open = false" 
                    @endif
                >
                    <ul 
                       {{ $attributes->twMerge([
                                "list-none ring-1 ring-gray-200 dark:ring-gray-700 dark:bg-gray-800 dark:text-gray-100",
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
