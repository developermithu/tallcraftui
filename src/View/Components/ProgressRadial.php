<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\HasProgressRadialColors;
use Developermithu\Tallcraftui\Traits\HasProgressRadialSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProgressRadial extends Component
{
    use HasProgressRadialColors, HasProgressRadialSizes;

    public function __construct(
        public float|int $value = 0,
        public float|int $max = 100,
        public ?string $label = null,
        public bool $withoutValue = false,
        public bool $dividedFormat = false,
        public ?int $stroke = null,
    ) {}

    public function percentage(): float
    {
        return ($this->value / $this->max) * 100;
    }

    public function value(): string
    {
        return $this->dividedFormat ? ($this->value . '/' . $this->max) : ($this->value / $this->max * 100 . '%');
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge(['relative rounded-full', $getSizeClasses()['size']]) }}>
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <!-- Background circle -->
                    <circle 
                        class="stroke-gray-200 dark:stroke-gray-700 fill-none" 
                        cx="50" 
                        cy="50" 
                        r="45" 
                        stroke-width="{{ $getStrokeWidth() }}"
                    />
                    <!-- Progress circle -->
                    <circle 
                        class="{{ $getColorClasses() }} fill-none transition-all duration-300"
                        cx="50" 
                        cy="50" 
                        r="45" 
                        stroke-width="{{ $getStrokeWidth() }}"
                        stroke-linecap="round"
                        stroke-dasharray="{{ $percentage() * 2.827 }}, 282.7"
                        transform="rotate(-90 50 50)"
                    />
                </svg>
                
                @if(!$withoutValue)
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="{{ $getSizeClasses()['text'] }} font-medium text-gray-700 dark:text-gray-200">
                            {{ $value() }}
                        </span>
                    </div>
                @endif

                @if($label)
                    <div class="mt-1 text-center">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</span>
                    </div>
                @endif
            </div>
        HTML;
    }
}
