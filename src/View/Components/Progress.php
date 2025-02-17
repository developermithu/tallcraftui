<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\HasProgressColors;
use Developermithu\Tallcraftui\Traits\HasProgressSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Progress extends Component
{
    use HasProgressColors, HasProgressSizes;

    public function __construct(
        public float|int $value = 0,
        public float|int $max = 100,
        public ?string $label = null,
        public bool $withoutValue = false,
        public bool $dividedFormat = false,
        public ?string $labelPosition = 'top',
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
            <div class="w-full">
                @if($label && $labelPosition === 'top')
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</span>
                        @if(!$withoutValue)
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $value() }}</span>
                        @endif
                    </div>
                @endif

                 <!-- Background container  -->
                <div class="w-full relative bg-gray-200 rounded-full dark:bg-gray-700 {{ $getSizeClasses() }}">
                     <!-- Progress bar  -->
                    <div class="absolute inset-0 transition-all duration-300 rounded-full  {{ $getColorClasses() }}"
                        style="width: {{ $percentage() }}%"
                        role="progressbar"
                        aria-valuenow="{{ $value }}"
                        aria-valuemin="0"
                        aria-valuemax="{{ $max }}"
                    >
                        @if(!$label && !$withoutValue   )
                            <span class="flex items-center justify-center h-full text-xs font-medium text-white whitespace-nowrap">{{ $value() }}</span>
                        @endif
                    </div>
                </div>

                @if($label && $labelPosition === 'bottom')
                    <div class="flex justify-between mt-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $label }}</span>
                        @if(!$withoutValue)
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $value() }}</span>
                        @endif
                    </div>
                @endif
            </div>
        HTML;
    }
}
