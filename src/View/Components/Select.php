<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?Collection $options = null,
        public ?string $placeholder = null,
        public ?string $hint = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('select', $this->attributes);
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

        $defaultSize = config('tallcraftui.select.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;

                    $errorClass = $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500': '';
                    $disabledClass = $attributes->get('disabled') ? "bg-gray-200 opacity-80 cursor-not-allowed" : '';
                    $readonlyClass = $attributes->get('readonly') ? "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" : '';
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" {{ $attributes->twMergeFor('label') }} />
                 @endif

                <div class="relative flex items-center flex-1">
                    <div class="w-full">
                        <select
                            id="{{ $uuid }}"
                            {{ 
                                $attributes
                                    ->withoutTwMergeClasses()
                                    ->twMerge([
                                        "block w-full border-gray-200 shadow-sm outline-none focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300",
                                        $sizeClasses(),
                                        $errorClass,
                                        $disabledClass,
                                        $readonlyClass,
                                        $roundedClass(),
                                    ])
                             }}>
                    
                            @if (!$options->isEmpty())
                                <option value="">-- {{ __($placeholder ?? 'choose option') }} -- </option>

                                @foreach ($options as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            @else
                                {{ $slot }}
                            @endif
                        </select>

                        @if($hint && !$error)
                            <x-tc-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                </div>
            </div>
        HTML;
    }
}
