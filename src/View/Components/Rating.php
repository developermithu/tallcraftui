<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\Sizes\HasRatingSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rating extends Component
{
    use HasRatingSizes;

    public string $uuid;

    public function __construct(
        public int $total = 5,
        public ?string $label = null,
        public ?string $hint = null,
        public bool $readonly = false,
        public ?string $icon = 'star',
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                $uuid = $uuid . $name;
                $required = $attributes->get('required', false);
            @endphp

            <div>
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required"
                        {{ $attributes->twMergeFor('label') }}
                    />
                @endif

                <div class="flex items-center gap-1" 
                    x-data="{ 
                        rating: @entangle($attributes->wire('model')), 
                        hoverRating: 0,
                        readonly: @js($readonly)
                    }"
                >
                    @for ($i = 1; $i <= $total; $i++)
                        <button type="button" class="focus:outline-hidden"

                            @if(!$readonly)
                                @click="rating = {{ $i }}"
                                @mouseenter="hoverRating = {{ $i }}"
                                @mouseleave="hoverRating = 0"
                            @endif
                        >
                            <x-tc-icon solid :name="$icon" 
                                {{ $attributes
                                    ->except('wire:model')
                                    ->withoutTwMergeClasses()
                                    ->twMerge([
                                        'hover:scale-110 active:scale-125 duration-200 text-gray-300',
                                        $getSizeClasses(),
                                ]) 
                            }}  
                                
                            x-bind:class="[
                                    !readonly ? 'cursor-pointer' : 'cursor-default',
                                    (hoverRating >= {{ $i }} || (!hoverRating && rating >= {{ $i }})) 
                                        ? 'text-amber-500!' 
                                        : ''
                                ]"  
                            />
                        </button>
                    @endfor
                </div>

                @if($hint)
                    <x-tc-hint :hint="$hint" />
                @endif

                @if($error)
                    <p class="mt-1 text-sm text-red-500">{{ $error }}</p>
                @endif
            </div>
        HTML;
    }
}
