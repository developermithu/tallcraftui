<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardHeader extends Component
{
    public function __construct(
        public string $title,
        public mixed $subtitle = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge(['px-5 pt-5']) }}>
                <h2 class="text-xl font-semibold sm:text-2xl dark:text-gray-200">{{ $title }}</h2>
                
                @if($subtitle)
                    <h5 class="text-sm text-gray-500 sm:text-base dark:text-gray-400">{{ $subtitle }}</h5>
                @endif
                
                {{ $slot }}
            </div>
        HTML;
    }
}
