<?php

namespace Developermithu\Tallcraftui\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Th extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?bool $sortable = false,
        public ?string $sortBy = null,
        public ?string $sortCol = null,
        public ?bool $sortAsc = false,
    ) {
        $this->sortBy ??= Str::snake(strtolower($this->label));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <th scope="col" {{ $attributes->twMerge(['p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400']) }}>
                @if($sortable)
                    <button 
                        wire:click="sortBy('{{ $sortBy }}')"
                        class="flex group items-center gap-x-1.5 uppercase"
                    >
                        {{ $label ? __($label) : $slot }}

                        @if ($sortCol === $sortBy)
                            <x-tc-icon :name="$sortAsc ? 'arrow-long-up' : 'arrow-long-down'" class="w-4 h-4" />
                        @else
                            <x-tc-icon name="arrows-up-down" class="w-4 h-4" />
                        @endif
                    </button>
                @else 
                    {{ $label ? __($label) : $slot }}
                @endif
            </th>
        HTML;
    }
}
