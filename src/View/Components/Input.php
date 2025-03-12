<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\Borders\HasInputBorders;
use Developermithu\Tallcraftui\Traits\Sizes\HasInputSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    use HasInputSizes, HasInputBorders;

    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $prefix = null,
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

    public function iconLeftClass(): string
    {
        return $this->icon || $this->iconLeft ? 'pl-9' : '';
    }

    public function iconRightClass(): string
    {
        return $this->iconRight ? 'pe-9' : '';
    }

    public function inputPrefixPrependClass(): string
    {
        return ($this->prefix || filled($this->prepend)) ? 'rounded-l-none!' : '';
    }

    public function inputSuffixAppendClass(): string
    {
        return ($this->suffix || filled($this->append)) ? 'rounded-r-none!' : '';
    }

    public function fileInputClass(): string
    {
        return $this->attributes->get('type') === 'file' ? 'file:border-0 dark:file:text-gray-300 file:bg-transparent file:px-3' : '';
    }

    public function disableClass(): string
    {
        return $this->attributes->get('disabled') ? 'bg-gray-200 opacity-80 cursor-not-allowed' : '';
    }

    public function readonlyClass(): string
    {
        return $this->attributes->get('readonly') ? 'bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none' : '';
    }

    public function prefixPrependClass(): string
    {
        return $this->prefix || $this->prepend && $this->prependIsSelect === false
            ? 'border border-gray-200 dark:border-gray-700 ' . $this->getAddonSizeClasses()
            : '';
    }

    public function suffixAppendClass(): string
    {
        return $this->suffix || $this->append && $this->appendIsSelect === false
            ? 'border border-gray-200 dark:border-gray-700 ' . $this->getAddonSizeClasses()
            : '';
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

                    $errorClass = $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500': '';
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" {{ $attributes->twMergeFor('label') }} />
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($iconLeft || $icon)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-tc-icon :name="$iconLeft ?? $icon" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-4') }} />
                        </span>
                    @endif

                    @if($prefix || filled($prepend))
                        <div
                            @class([
                                "inline-flex items-center text-sm text-gray-500 rounded-r-none min-w-fit border-e-0 bg-gray-50 dark:bg-gray-700 dark:text-gray-300",
                                $prefixPrependClass(),
                                $getPrefixRoundClasses(),
                            ])
                        >
                            {{  $prefix ?? $prepend }}
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
                                    ->withoutTwMergeClasses()
                                    ->twMerge([
                                        "block w-full border-gray-200 shadow-xs outline-hidden focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-400",
                                        $getSizeClasses(),
                                        $iconLeftClass(),
                                        $iconRightClass(),
                                        $inputPrefixPrependClass(),
                                        $inputSuffixAppendClass(),
                                        $fileInputClass(),
                                        $disableClass(),
                                        $readonlyClass(),
                                        $getRoundedClass(),
                                        $errorClass,
                                        filled($prepend) ? 'rounded-l-none' : '',
                                        filled($append) ? 'rounded-r-none' : '',
                                    ])
                                }} 
                            />
                    </div>

                    @if($iconRight)
                        <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
                            <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-4') }} />
                        </span>
                    @endif

                    @if($suffix || filled($append))
                        <div 
                            @class([
                                "inline-flex items-center min-w-fit rounded-l-none border-s-0 bg-gray-50 text-sm text-gray-500 dark:bg-gray-700 dark:text-gray-300",
                                $suffixAppendClass(),
                                $getSuffixRoundClasses(),   
                            ])
                        >
                            {{ $suffix ?? $append }}
                        </div>
                    @endif
                </div>

                @if($hint && !$error)
                    <x-tc-hint :hint="$hint" />
                @endif

                @if($error)
                    <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                @endif
            </div>
        HTML;
    }
}
