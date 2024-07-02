<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $preffix = null,
        public ?string $suffix = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <button type="button" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium tracking-wide text-white transition-colors duration-200 rounded-md bg-neutral-950 hover:bg-neutral-900 focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 focus:shadow-outline focus:outline-none">
                @if($label)
                    {{ $label }}
                @else 
                    {{ $slot }}
                @endif
            </button>
        HTML;
    }
}
