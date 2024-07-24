<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownItem extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <a {{ $attributes->class([
                        'block flex gap-x-1.5 items-center w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out',
                    ]) 
                }}

                {{ $attributes->get('href') ? 'wire:navigate' : '' }}
            >
                @if($icon)
                    <x-icon :name="$icon" />
                @endif

                {{ $label ? __($label) : '' }}

                {{ $slot }}
            </a>
        HTML;
    }
}
