<?php

namespace Developermithu\Tallcraftui\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tr extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <tr {{ $attributes
                    ->except(['href'])
                    ->twMerge([
                        "hover:bg-gray-50 dark:hover:bg-gray-700",
                        $attributes->get('href') ? "cursor-pointer" : "",
                    ]) 
                }} 

                @if($attributes->get('href'))
                    onclick="window.location='{{ $attributes->get('href') }}'"
                @endif    
            >
                {{ $slot }}
            </tr>
        HTML;
    }
}
