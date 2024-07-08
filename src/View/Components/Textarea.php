<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $iconClass = 'size-4',
        public ?string $hint = null,
        public ?bool $inline = false,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div 
                @class([
                    '',
                    'inline-flex items-center gap-3' => $inline 
                ])
            >
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    
                    $uuid = $uuid . $name;
                    
                    // Remove extra space & make label lowercase
                    $label = trim(Str::lower($label));

                    // Check if the label contains '*'
                    $hasStar = strpos($label, '*') !== false;

                    // Remove '*' from the label for translation
                    $labelWithoutStar = rtrim($label, ' *');
                @endphp
            
                @if($label)
                    <label for="{{ $uuid }}"
                        @class([
                            "text-sm font-medium capitalize text-gray-700",
                            "block mb-1.5" => !$inline    
                        ])
                    >     
                        {{ __($labelWithoutStar) }}

                        @if ($hasStar || $attributes->get('required'))
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($iconLeft)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-icon :name="$iconLeft" :class="$iconClass" />
                        </span>
                    @endif
                
                    <div class="w-full">
                        <textarea
                            id="{{ $uuid }}"
                            placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                            autocomplete="{{ $attributes->get('autocomplete', 'off') }}"
                            {{ 
                                $attributes
                                    ->merge(['rows' => '3'])
                                    ->class([
                                        "block w-full rounded border-gray-200 py-2.5 shadow-sm text-sm outline-none dark:border-gray-700  dark:bg-gray-800 dark:text-white",
                                        "pl-9" => $iconLeft, 
                                        "pe-9" => $icon || $iconRight,
                                        "border-red-500 focus:border-red-500 focus:ring-red-500" => $error,
                                        "bg-gray-200 opacity-80 cursor-not-allowed" => $attributes->get('disabled'),
                                        "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" => $attributes->get('readonly'),
                                    ])
                             }} 
                        ></textarea>

                        @if($hint && !$error)
                            <p class="mt-1 text-sm text-gray-500"> {{ $hint }} </p>
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>

                    @if($iconRight || $icon)
                        <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
                            <x-icon :name="$iconRight ?? $icon" :class="$iconClass" />
                        </span>
                    @endif
                </div>
            </div>
        HTML;
    }
}
