<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public function __construct() {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <nav class="flex order-2">
                <ol {{ $attributes->twMerge(["inline-flex items-center space-x-1 text-sm font-medium md:space-x-2"]) }}>                  
                    {{ $slot }}                    
                </ol>
            </nav>
        HTML;
    }
}
