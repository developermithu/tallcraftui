<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\ToggleTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    use ToggleTrait;

    public function __construct(
        public ?string $label = null,
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
                $label = trim($label);

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
                
                $isRequired = $hasStar || $required;
            @endphp
            
            <label @class(["inline-flex items-center cursor-pointer gap-3"])>
                <input type="checkbox" class="sr-only peer" {{ $attributes->except($colorAttributes) }}>
                
                @if($textLeft)
                    @if($label)
                        <span {{ $attributes->twMergeFor('label', 'text-sm font-medium text-gray-700 dark:text-gray-100', $error ? 'text-red-500' : '') }}>
                            {{ __($labelWithoutStar) }}

                            @if ($isRequired)
                                <span class="text-red-500">*</span>
                            @endif
                        </span>
                    @endif
                @endif

                <div {{ $attributes
                    ->whereStartsWith('class')
                    ->except(['wire:model'])
                    ->withoutTwMergeClasses()
                    ->twMerge([
                        "relative bg-gray-200 rounded-full peer peer-focus:ring-2 ring-offset-2 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:rtl:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5  after:bg-white after:border-gray-300 after:border after:rounded-full after:transition-all dark:border-gray-600 duration-200",
                        $error ? 'bg-red-500' : '',
                        $getColorClasses(),
                        $getSizeClasses(),
                    ]) 
                }}></div>
                
                @if(!$textLeft)
                    @if($label)
                        <span {{ $attributes->twMergeFor('label', 'text-sm font-medium text-gray-700 dark:text-gray-100', $error ? 'text-red-500' : '') }}
                        >
                            {{ __($labelWithoutStar) }}

                            @if ($isRequired)
                                <span class="text-red-500">*</span>
                            @endif
                        </span>
                    @endif
                @endif
            </label>
        HTML;
    }
}
