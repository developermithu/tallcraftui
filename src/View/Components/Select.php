<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\HasSelectSizes;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    use HasSelectSizes;
    
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public Collection|array $options = new Collection(),
        public ?string $optionValue = 'id',
        public ?string $optionLabel = 'name',
        public ?string $placeholder = null,
        public bool $withoutPlaceholder = false,
        public ?string $hint = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('select', $this->attributes);
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
                                        "block w-full border-gray-200 shadow-xs outline-hidden focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300",
                                        $getSizeClasses(),
                                        $errorClass,
                                        $disabledClass,
                                        $readonlyClass,
                                        $roundedClass(),
                                    ])
                             }}>
                    
                            @if(!$withoutPlaceholder)
                                <option value="">-- {{ __($placeholder ?? 'choose option') }} -- </option>
                            @endif

                            @if (is_array($options) || $options instanceof Illuminate\Support\Collection)
                                @foreach ($options as $key => $option)
                                    @if (is_object($option) || is_array($option))
                                        <option value="{{ data_get($option, $optionValue) }}">{{ data_get($option, $optionLabel) }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $option }}</option>
                                    @endif
                                @endforeach
                            @endif
                            
                            {{ $slot }}
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
