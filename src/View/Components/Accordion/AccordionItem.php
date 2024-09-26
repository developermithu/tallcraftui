<?php

namespace Developermithu\Tallcraftui\View\Components\Accordion;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccordionItem extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?string $title = null,
        public ?bool $iconPlusMinus = false,
        public ?bool $activeBorder = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div x-data="{ id: @js($id) }" 
                {{ $attributes->withoutTwMergeClasses()->twMerge([
                        'cursor-pointer group',
                        $activeBorder ? 'duration-200 ease-out bg-transparent border rounded-md' : '',
                    ])
                }}
                
                @if($activeBorder)
                    :class="{ 'border-gray-200/60 dark:border-gray-700' : activeItem === id, 'border-transparent text-gray-600 dark:text-gray-300' : activeItem !== id }" 
                @endif

                :class="{ 'dark:text-gray-100 text-gray-800' : activeItem === id, 'text-gray-600 dark:text-gray-300' : activeItem !== id }" 
            >
                <button 
                    @click="toggleItem(id)" 
                    {{ $attributes->twMergeFor(
                            'title',
                            'flex items-center justify-between w-full p-4 text-left select-none',
                        ) 
                    }}
                >
                    <span>{{ __($title) }}</span>
                    
                    @if($iconPlusMinus)
                        <div :class="{ 'rotate-90': activeItem === id }" class="relative flex items-center justify-center w-2.5 h-2.5 duration-300 ease-out">
                            <div class="absolute w-0.5 h-full bg-gray-500 dark:bg-gray-300 rounded-full"></div>
                            <div :class="{ 'rotate-90': activeItem === id }" class="absolute w-full h-0.5 ease duration-500 bg-gray-500 dark:bg-gray-300 rounded-full"></div>
                        </div>
                    @else
                        <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeItem === id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    @endif
                </button>
                
                <div x-show="activeItem === @js($id)" x-collapse x-cloak>
                    <div {{ $attributes->twMergeFor('content', 'p-4 pt-0 opacity-70') }}>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        HTML;
    }
}
