<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hint extends Component
{
    public function __construct(
        public ?string $hint = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <p {{ $attributes
                    ->twMerge(["mt-1 text-sm text-gray-500 dark:text-gray-400"]) 
                }}
            >{{ $hint }}</p>
        HTML;
    }
}
