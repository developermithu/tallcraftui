<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Label extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $for = null,
        public bool $inline = false,
        public bool $required = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                // Remove extra space & make label lowercase
                $label = trim(Str::lower($label));

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
                
                $isRequired = $hasStar || $required;
                $checkboxOrRadio = $attributes->get('checkbox') || $attributes->get('radio');
            @endphp
                    
            <label for="{{ $for }}"
                {{ $attributes
                    ->class([
                        "text-sm font-medium capitalize text-gray-700 dark:text-gray-100",
                        "block mb-1.5" => !$inline && !$checkboxOrRadio   
                    ])
                }}
            >     
                {{ __($labelWithoutStar) }}

                @if ($isRequired)
                    <span class="text-red-500">*</span>
                @endif
            </label>
        HTML;
    }
}