<?php

namespace Developermithu\Tallcraftui\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tab extends Component
{
    public function __construct(
        public ?string $as = null,
        public ?bool $noSeparator = false,
    ) {}

    public function itemSwitchClass(): string
    {
        return $this->as === 'switch' ? 'space-x-0 justify-between' : '';
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div
                x-data="{
                    activeTab: @entangle($attributes->wire('model')),
                    items: []
                }"
                class="w-full"
            >
                <div                         
                    {{ $attributes->whereDoesntStartWith('wire:model')
                        ->withoutTwMergeClasses()
                        ->twMerge([
                                $as === 'switch' ? 'bg-gray-100 dark:bg-gray-800 px-1 rounded' : '',
                                ($as != 'switch') && !$noSeparator ? 'border-b border-gray-200 dark:border-gray-700' : '',
                            ]) 
                    }}
                >
                    <nav                         
                        {{ $attributes->twMergeFor('items', 'flex -mb-px space-x-8', $itemSwitchClass()) }}
                        aria-label="items"
                    >
                        {{ $items }}
                    </nav>
                </div>
                
                <div {{ $attributes->twMergeFor('content', 'mt-4') }}>
                    {{ $slot }}
                </div>
            </div>
        HTML;
    }
}
