<?php

namespace Developermithu\Tallcraftui\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabItem extends Component
{
    public function __construct(
        public ?string $id = null,
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?bool $active = false,
        public ?string $as = null,
        public ?string $activeClass = '',
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <button
                type="button"
                x-data="{ id: @js($id) }"
                x-init="
                    items.push(id);
                    if (@js($active)) {
                        activeTab = id;
                    }
                "
                @click="activeTab = id"
            
                @if($as === 'switch')
                    :class="{ 
                        '{{ $activeClass }}' : activeTab === id, 
                        'bg-white dark:bg-gray-700 dark:text-gray-100 text-gray-700': activeTab === id, 
                        'bg-transparent dark:text-gray-400 text-gray-500': activeTab !== id 
                    }"
                    
                @else 
                    :class="{ 
                        '{{ $activeClass }}' : activeTab === id, 
                        'border-primary text-primary': activeTab === id, 
                        'border-transparent text-gray-500 dark:text-gray-300 dark:hover:text-gray-200 hover:text-gray-700 hover:border-gray-300 dark:hover:border-gray-400': activeTab !== id 
                    }"
                @endif

                {{ $attributes->withoutTwMergeClasses()->twMerge([
                        'text-sm px-1 inline-flex items-center justify-center font-semibold whitespace-nowrap transition ease-in-out',
                        $as != 'switch' ? 'py-4 border-b-2 gap-x-1.5' : '',
                        $as === 'switch' ? 'py-2 my-1 rounded w-full gap-x-2' : '',
                    ])
                }}
            >
                @if($icon)
                    <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', 'size-[18px]') }} />
                @endif

                {{ __($label) }}

                @if($iconRight)
                    <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', 'size-[18px]') }} />
                @endif
            </button>
        HTML;
    }
}
