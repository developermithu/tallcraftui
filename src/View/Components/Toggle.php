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
                
            <div x-data="{ switchOn: false }" class="flex items-center space-x-2">
                <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn" {{ $attributes->whereDoesntStartWith('class') }}>

                <button 
                    x-ref="switchButton"
                    type="button" 
                    @click="switchOn = ! switchOn"
                    :class="switchOn ? '!bg-primary' : 'bg-neutral-200'" 
                    @class([
                        "relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10", 
                        "!bg-red-500" => $error,
                    ])
                    x-cloak
                    >
                        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'" class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                </button>

                <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')" 
                    :class="{ '!text-primary': switchOn, 'text-gray-700 dark:text-gray-100': ! switchOn }"
                    @class(["text-sm font-medium select-none", "!text-red-500" => $error])
                    x-cloak
                    >
                        {{ Str::ucfirst(__($labelWithoutStar)) }}

                        @if ($isRequired)
                            <span class="text-red-500">*</span>
                        @endif
                </label>
            </div>
        HTML;
    }
}
