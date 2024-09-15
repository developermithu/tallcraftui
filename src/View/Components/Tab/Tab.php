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

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div
                x-data="{
                    activeTab: @entangle($attributes->wire('model')),
                    items: []
                }"
                {{ $attributes->whereDoesntStartWith('wire:model')->twMerge(['w-full']) }}
            >
                <div @class(['border-b border-gray-200 dark:border-gray-700' => ($as != 'switch') && !$noSeparator, 'bg-gray-100 dark:bg-gray-800 px-1 rounded' => $as === 'switch'])>
                    <nav @class(["flex -mb-px space-x-8", '!space-x-0 justify-between' => $as === 'switch']) aria-label="items">
                        {{ $items }}
                    </nav>
                </div>
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        HTML;
    }
}
