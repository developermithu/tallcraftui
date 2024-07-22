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

    public function inputRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => "rounded-none",
            $this->attributes->get('rounded-sm') => "rounded-sm",
            $this->attributes->get('rounded-md') => "rounded-md",
            $this->attributes->get('rounded-lg') => "rounded-lg",
            $this->attributes->get('rounded-xl') => "rounded-xl",
            $this->attributes->get('rounded-2xl') => "rounded-2xl",
            $this->attributes->get('rounded-3xl') => "rounded-3xl",
            $this->attributes->get('rounded-full') => "rounded-full",
            default => "rounded",
        };
    }
    
    public function preffixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => "rounded-s-none",
            $this->attributes->get('rounded-sm') => "rounded-s-sm",
            $this->attributes->get('rounded-md') => "rounded-s-md",
            $this->attributes->get('rounded-lg') => "rounded-s-lg",
            $this->attributes->get('rounded-xl') => "rounded-s-xl",
            $this->attributes->get('rounded-2xl') => "rounded-s-2xl",
            $this->attributes->get('rounded-3xl') => "rounded-s-3xl",
            $this->attributes->get('rounded-full') => "rounded-s-full",
            default => "rounded-s",
        };
    }
    
    public function suffixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => "rounded-e-none",
            $this->attributes->get('rounded-sm') => "rounded-e-sm",
            $this->attributes->get('rounded-md') => "rounded-e-md",
            $this->attributes->get('rounded-lg') => "rounded-e-lg",
            $this->attributes->get('rounded-xl') => "rounded-e-xl",
            $this->attributes->get('rounded-2xl') => "rounded-e-2xl",
            $this->attributes->get('rounded-3xl') => "rounded-e-3xl",
            $this->attributes->get('rounded-full') => "rounded-e-full",
            default => "rounded-e",
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div @class(['flex items-center gap-3' => $inline])>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;
                @endphp
            
                @if($label)
                    <x-tall-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" />
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($iconLeft || $icon)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-icon :name="$iconLeft ?? $icon" class="dark:text-gray-400 {{ $iconClass }}" />
                        </span>
                    @endif

                    @if($preffix || $prepend)
                        <div
                            @class([
                                "inline-flex items-center text-sm text-gray-500 rounded-r-none min-w-fit border-e-0 bg-gray-50 dark:bg-gray-700 dark:text-gray-300",
                                "px-4 py-2.5 border border-gray-200 dark:border-gray-700" => $preffix || $prepend && $prependIsSelect === false,    
                                $preffixRoundClasses(),
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
                                        "block w-full border-gray-200 py-2.5 shadow-sm text-sm outline-none focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-400",
                                        "pl-9" => $icon || $iconLeft, 
                                        "pe-9" => $iconRight, 
                                        "rounded-l-none" => $preffix || $prepend, 
                                        "rounded-r-none" => $suffix || $append,
                                        "file:border-0 dark:file:text-gray-300 file:bg-transparent file:px-3" => $attributes->get('type') === 'file',
                                        "border-red-500 dark:border-red-500 focus:border-red-500 focus:ring-red-500" => $error,
                                        "bg-gray-200 opacity-80 cursor-not-allowed" => $attributes->get('disabled'),
                                        "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" => $attributes->get('readonly'),
                                        $inputRoundClasses(),
                                    ])
                             }} 
                            />

                        @if($hint && !$error)
                            <x-tall-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>

                    @if($iconRight)
                        <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
                            <x-icon :name="$iconRight" class="dark:text-gray-400 {{ $iconClass }}" />
                        </span>
                    @endif

                    @if($suffix || $append)
                        <div 
                            @class([
                                "inline-flex items-center min-w-fit rounded-l-none border-s-0 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:text-gray-300",
                                "px-4 py-2.5 border border-gray-200 dark:border-gray-700" => $suffix || $append && $appendIsSelect === false,  
                                $suffixRoundClasses(),   
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
