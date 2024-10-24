<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
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
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?bool $autoResize = false,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('textarea', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div @class(['inline-flex items-center gap-3' => $inline])>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" {{ $attributes->twMergeFor('label') }} />
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($icon || $iconLeft)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-tc-icon :name="$iconLeft" class="size-4" />
                        </span>
                    @endif
                
                    <div class="w-full">
                        <textarea
                            @if($autoResize)
                                x-data="{ 
                                    resize () { 
                                        $el.style.height = '0px'; 
                                        $el.style.height = $el.scrollHeight + 'px' 
                                    } 
                                }"
                                x-init="resize()"
                                @input="resize()"
                            @endif
                            
                            id="{{ $uuid }}"
                            placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                            autocomplete="{{ $attributes->get('autocomplete', 'off') }}"
                            {{ 
                                $attributes
                                    ->withoutTwMergeClasses()
                                    ->merge(['rows' => 3])
                                    ->twMerge([
                                            "block w-full border-gray-200 py-2.5 shadow-sm text-sm outline-none focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-white",
                                            $iconLeft ? 'pl-9' : '', 
                                            $icon || $iconRight ? 'pe-9' : '',
                                            $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500' : '',
                                            $attributes->get('disabled') ? 'bg-gray-200 opacity-80 cursor-not-allowed' : '',
                                            $attributes->get('readonly') ? 'bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none' : '',
                                            $roundedClass(),
                                            $autoResize ? 'min-h-[80px]' : '',
                                    ])
                             }} 
                        ></textarea>

                        @if($hint && !$error)
                            <x-tc-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>

                    @if($iconRight)
                        <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
                            <x-tc-icon :name="$iconRight ?? $icon" class="size-4" />
                        </span>
                    @endif
                </div>
            </div>
        HTML;
    }
}
