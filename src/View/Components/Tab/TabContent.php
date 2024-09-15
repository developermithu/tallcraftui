<?php

namespace Developermithu\Tallcraftui\View\Components\Tab;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TabContent extends Component
{
    public function __construct(
        public ?string $id = null,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div x-show="activeTab === @js($id)" x-cloak {{ $attributes->twMerge([]) }} >
                {{ $slot }}
            </div>
        HTML;
    }
}
