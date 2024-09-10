<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $textLeft = false,
        public bool $required = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
               
                // Remove extra space & make label lowercase
                $label = trim(Str::lower($label));

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
                
                $isRequired = $hasStar || $required;
            @endphp
            
            <label @class(["inline-flex items-center cursor-pointer gap-3", "flex-row-reverse" => $textLeft])>
                <input type="checkbox" class="sr-only peer" {{ $attributes->whereDoesntStartWith('class') }}>
                
                <div @class([
                        "relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary/60 dark:peer-focus:ring-primary/60 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary",
                        "!bg-red-500" => $error,
                ])></div>
                
                @if($label)
                    <span @class(["text-sm font-medium text-gray-700 dark:text-gray-100", "!text-red-500" => $error])>
                        {{ Str::ucfirst(__($labelWithoutStar)) }}

                        @if ($isRequired)
                            <span class="text-red-500">*</span>
                        @endif
                    </span>
                @endif
            </label>
        HTML;
    }
}
