<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
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

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('input', $this->attributes);
    }

    public function prefixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-s-none',
            $this->attributes->get('rounded-sm') => 'rounded-s-sm',
            $this->attributes->get('rounded-md') => 'rounded-s-md',
            $this->attributes->get('rounded-lg') => 'rounded-s-lg',
            $this->attributes->get('rounded-xl') => 'rounded-s-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-s-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-s-3xl',
            $this->attributes->get('rounded-full') => 'rounded-s-full',
            default => 'rounded-s',
        };
    }

    public function suffixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-e-none',
            $this->attributes->get('rounded-sm') => 'rounded-e-sm',
            $this->attributes->get('rounded-md') => 'rounded-e-md',
            $this->attributes->get('rounded-lg') => 'rounded-e-lg',
            $this->attributes->get('rounded-xl') => 'rounded-e-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-e-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-e-3xl',
            $this->attributes->get('rounded-full') => 'rounded-e-full',
            default => 'rounded-e',
        };
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
        return ($this->prefix || filled($this->prepend)) ? '!rounded-l-none' : '';
    }

    public function inputSuffixAppendClass(): string
    {
        return ($this->suffix || filled($this->append)) ? '!rounded-r-none' : '';
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

    public function sizeClasses(): string
    {
        $sizes = [
            'xs' => 'py-1 text-xs',
            'sm' => 'py-1.5 text-xs',
            'md' => 'py-2 text-sm',
            'lg' => 'py-2.5 text-base',
            'xl' => 'py-3 text-lg',
            '2xl' => 'py-3.5 text-xl',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.input.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function addonSizeClasses(): string
    {
        $sizes = [
            'xs' => 'px-1.5 py-1 text-xs',
            'sm' => 'px-2 py-1.5 text-xs',
            'md' => 'px-3 py-2 text-sm',
            'lg' => 'px-4 py-3 text-base',
            'xl' => 'px-5 py-4 text-lg',
            '2xl' => 'px-6 py-3.5 text-xl',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.input.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function prefixPrependClass(): string
    {
        return $this->prefix || $this->prepend && $this->prependIsSelect === false
            ? 'border border-gray-200 dark:border-gray-700 ' . $this->addonSizeClasses()
            : '';
    }

    public function suffixAppendClass(): string
    {
        return $this->suffix || $this->append && $this->appendIsSelect === false
            ? 'border border-gray-200 dark:border-gray-700 ' . $this->addonSizeClasses()
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
                                $prefixRoundClasses(),
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
                                        "block w-full border-gray-200 shadow-sm outline-none focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-400",
                                        $sizeClasses(),
                                        $iconLeftClass(),
                                        $iconRightClass(),
                                        $inputPrefixPrependClass(),
                                        $inputSuffixAppendClass(),
                                        $fileInputClass(),
                                        $disableClass(),
                                        $readonlyClass(),
                                        $roundedClass(),
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
                                $suffixRoundClasses(),   
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
