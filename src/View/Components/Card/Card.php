<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Developermithu\Tallcraftui\Traits\CardTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    use CardTrait;

    public function __construct() {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge([
                    'border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800',
                    $getRoundedClass(),
                    $shadowClass(),
                ])
            }}>            
                {{ $slot }}
            </div>
        HTML;
    }
}
