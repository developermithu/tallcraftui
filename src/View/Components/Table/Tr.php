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
            @php
                $href = $attributes->get('href');

                // Never render script URLs into a click handler
                if ($href && preg_match('/^\s*(javascript|data|vbscript):/i', $href)) {
                    $href = null;
                }

                $navigate = $attributes->has('wire:navigate');
            @endphp

            <tr {{ $attributes
                    ->except(['href', 'wire:navigate'])
                    ->twMerge([
                        $href ? "cursor-pointer" : "",
                    ]) 
                }} 

                {{-- Links, buttons and form controls inside the row handle their own clicks --}}
                @if($href)
                    x-data="{ href: @js($href), navigate: @js($navigate) }"
                    @click="
                        if ($event.target.closest('a, button, input, select, textarea, label')) return;

                        if ($event.metaKey || $event.ctrlKey) return window.open(href, '_blank');

                        navigate && window.Livewire ? Livewire.navigate(href) : window.location.assign(href);
                    "
                @endif    
            >
                {{ $slot }}
            </tr>
        HTML;
    }
}
