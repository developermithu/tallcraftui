<?php

namespace Developermithu\Tallcraftui\View\Components\Accordion;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Accordion extends Component
{
    public function __construct(
        public ?bool $borderless = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php 
                $wireModel = $attributes->wire('model');
            @endphp

            <div
                x-data="{
                    activeItem: @if($wireModel) @entangle($wireModel) @else null @endif,
                    toggleItem(id) {
                        this.activeItem = this.activeItem === id ? null : id;
                    }
                }"
                
                {{ $attributes->whereDoesntStartWith('wire:model')
                        ->twMerge([
                            'relative w-full mx-auto overflow-hidden font-normal bg-transparent rounded-md',
                            !$borderless ? 'border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700' : '',
                    ]) 
                }}
            >
                {{ $slot }}
            </div>
        HTML;
    }
}
