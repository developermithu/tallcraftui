<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardContent extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge(['px-5 py-5 space-y-3 sm:space-y-4']) }}>
                {{ $slot }}
            </div>
        HTML;
    }
}
