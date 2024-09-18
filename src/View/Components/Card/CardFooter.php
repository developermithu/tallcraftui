<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardFooter extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge(['px-5 pb-5']) }} >
                {{ $slot }}
            </div>
        HTML;
    }
}
