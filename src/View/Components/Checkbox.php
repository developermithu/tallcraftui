<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\Colors\HasCheckboxColors;
use Developermithu\Tallcraftui\Traits\Sizes\HasCheckboxSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component
{
    use HasCheckboxColors, HasCheckboxSizes;

    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $textLeft = false,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('checkbox', $this->attributes);
    }

    public function disabledAndReadonlyClass(): string
    {
        return $this->attributes->get('disabled') || $this->attributes->get('readonly') ? 'text-gray-300 pointer-events-none' : '';
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                $uuid = $uuid . $name;
                $required = $attributes->get('required') ? true : false;
                $errorClass = $error ? 'border-red-300' : '';
            @endphp
                
            <div class="relative flex gap-x-3">
                @if($textLeft)
                    <div class="leading-6">
                        @if($label)
                            <x-tc-label :for="$uuid" :label="$label" :required="$required" checkbox 
                                {{ $attributes->twMergeFor('label', $error ? 'text-red-500' : '') }}
                            />
                        @endif
                        
                        @if($hint)
                            <x-tc-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                @endif

                <div class="flex items-center h-6">
                    <input id="{{ $uuid }}" type="checkbox"
                        {{ $attributes
                            ->except($colorAttributes)
                            ->withoutTwMergeClasses()
                            ->twMerge([
                                "border-gray-300",
                                $getSizeClasses(), 
                                $getColorClasses(),       
                                $errorClass,                                
                                $disabledAndReadonlyClass(),
                                $roundedClass(),                        
                            ])
                        }}
                    />
                </div>

                <!-- Default -->
                @if(!$textLeft)
                    <div class="leading-6">
                        @if($label)
                            <x-tc-label :for="$uuid" :label="$label" :required="$required" checkbox 
                                {{ $attributes->twMergeFor('label', $error ? 'text-red-500' : '') }}
                            />
                        @endif
                        
                        @if($hint)
                            <x-tc-hint :hint="$hint" />
                        @endif
                    </div>
                @endif
            </div>
        HTML;
    }
}
