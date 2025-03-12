<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\Colors\HasRangeColors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Range extends Component
{
    use HasRangeColors;

    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?int $min = 0,
        public ?int $max = 100,
        public ?int $step = 1,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div @class(['inline-flex w-full items-center gap-3' => $inline])>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" 
                        {{ $attributes->twMergeFor('label', !$inline ? 'mb-3' : '') }}
                    />
                @endif

                <div class="relative flex items-center flex-1">
                    <input
                        type="range"
                        id="{{ $uuid }}"
                        min="{{ $min }}"
                        max="{{ $max }}"
                        step="{{ $step }}"
                        {{ 
                            $attributes
                                ->withoutTwMergeClasses()
                                ->except($colorAttributes)
                                ->twMerge([
                                    "block w-full h-2 appearance-none cursor-pointer bg-transparent z-30",
                                    "[&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-0 [&::-moz-range-thumb]:w-5 [&::-moz-range-thumb]:h-5 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-0 [&::-ms-thumb]:w-5 [&::-ms-thumb]:h-5 [&::-ms-thumb]:appearance-none [&::-ms-thumb]:rounded-full [&::-ms-thumb]:border-0 [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-runnable-track]:overflow-hidden [&::-moz-range-track]:rounded-full [&::-ms-track]:rounded-full [&::-moz-range-progress]:rounded-full [&::-ms-fill-lower]:rounded-full [&::-webkit-slider-runnable-track]:bg-gray-200 [&::-moz-range-track]:bg-gray-200 [&::-ms-track]:bg-gray-200 dark:[&::-webkit-slider-runnable-track]:bg-gray-800 dark:[&::-moz-range-track]:bg-gray-800 dark:[&::-ms-track]:bg-gray-800",
                                    $getColorClasses(),
                                ])
                        }}
                    />
                </div>

                @if($hint && !$error)
                    <x-tc-hint :hint="$hint" @class(["mt-2.5" => !$inline]) />
                @endif
                
                @if($error)
                    <p @class(["text-sm text-red-500", "mt-2.5" => !$inline])>{{ $error }}</p>
                @endif
            </div>
        HTML;
    }
}
