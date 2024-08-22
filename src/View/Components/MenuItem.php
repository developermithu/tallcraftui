<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public bool $iconOutline = false,
        public ?string $badge = null,
        public bool $badgeEnd = false,

        // Menu Item as link
        public ?string $link = null,
        public ?bool $external = false,
        public ?bool $noWireNavigate = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <li>
                <a {{ $attributes->withoutTwMergeClasses()->twMerge([
                            'inline-flex items-center w-full px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 gap-x-3 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-white group transition ease-in-out cursor-pointer',
                        ]) 
                    }}

                    @if($link)
                        href="{{ $link }}"
                    @endif
                    
                    @if($link && $external)
                        target="_blank"
                    @endif

                    @if($link && !$external && !$noWireNavigate)
                        wire:navigate
                    @endif
                >
                    @if($icon)
                        <x-tc-icon 
                            :name="$icon" 
                            :solid="$iconOutline ? false : true"
                            {{ $attributes->twMergeFor('icon', 'text-gray-400 transition ease-in-out group-hover:text-gray-500 dark:group-hover:text-gray-300') }}                    
                        />
                    @endif

                    {{ $label ? __($label) : '' }}

                    {{ $slot }}
                    
                    @if($badge)
                        <div @class(['flex justify-end flex-1' => $badgeEnd])>
                            <x-tc-badge :label="$badge" amber {{ $attributes->twMergeFor('badge', 'rounded-full') }} />
                        </div>
                    @endif
                </a>
            </li>
        HTML;
    }
}
