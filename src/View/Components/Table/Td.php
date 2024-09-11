<?php

namespace Developermithu\Tallcraftui\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Td extends Component
{
    public function __construct(
        public ?string $label = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <td {{ $attributes->twMerge(['p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400']) }}>
                {{ $label ? __($label) : $slot }}
            </td>
        HTML;
    }
}
