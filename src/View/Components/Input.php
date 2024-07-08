<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $iconClass = 'size-4',
        public ?string $hint = null,
        public ?string $preffix = null,
        public ?string $suffix = null,
        public ?bool $inline = false,

        // Slots
        public mixed $prepend = null,
        public mixed $append = null,

        // If prepend and append does not contain select tag
        // then pass <x-input :prependIsSelect="false" />
        public bool $prependIsSelect = true,
        public bool $appendIsSelect = true,
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

                    @if($preffix || $prepend)
                        <div
                            @class([
                                "inline-flex items-center text-sm text-gray-500 rounded-r-none min-w-fit rounded-s-md border-e-0 bg-gray-50",
                                "px-4 py-2.5 border border-gray-200" => $preffix || $prepend && $prependIsSelect === false,    
                            ])
                        >
                            {{ $prepend ?? $preffix }}
                        </div>
                    @endif
                
                    <div class="w-full">
                        <input
                            id="{{ $uuid }}"
                            placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                            autocomplete="{{ $attributes->get('autocomplete', 'off') }}"
                            {{ 
                                $attributes
                                    ->merge(['type' => 'text'])
                                    ->class([
                                        "block w-full rounded border-gray-200 py-2.5 shadow-sm text-sm outline-none dark:border-gray-700  dark:bg-gray-800 dark:text-white",
                                        "pl-9" => $iconLeft, 
                                        "pe-9" => $icon || $iconRight, 
                                        "rounded-l-none" => $preffix || $prepend, 
                                        "rounded-r-none" => $suffix || $append,
                                        "file:border-0 file:bg-transparent file:px-3" => $attributes->get('type') === 'file',
                                        "border-red-500 focus:border-red-500 focus:ring-red-500" => $error,
                                        "bg-gray-200 opacity-80 cursor-not-allowed" => $attributes->get('disabled'),
                                        "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" => $attributes->get('readonly'),
                                    ])
                             }} 
                            />

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

                    @if($suffix || $append)
                        <div 
                            @class([
                                "inline-flex items-center min-w-fit rounded-s-md rounded-l-none border-s-0 bg-gray-50 text-sm text-gray-500",
                                "px-4 py-2.5 border border-gray-200" => $suffix || $append && $appendIsSelect === false,     
                            ])
                        >
                            {{ $append ?? $suffix }}
                        </div>
                    @endif
                </div>
            </div>
        HTML;
    }
}
