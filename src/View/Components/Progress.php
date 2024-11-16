<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Progress extends Component
{
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

    public function colorClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'bg-secondary',
            $this->attributes->get('black') => 'bg-black',
            $this->attributes->get('white') => 'bg-white',
            $this->attributes->get('slate') => 'bg-slate-500',
            $this->attributes->get('gray') => 'bg-gray-500',
            $this->attributes->get('zinc') => 'bg-zinc-500',
            $this->attributes->get('neutral') => 'bg-neutral-500',
            $this->attributes->get('stone') => 'bg-stone-500',
            $this->attributes->get('red') => 'bg-red-500',
            $this->attributes->get('orange') => 'bg-orange-500',
            $this->attributes->get('amber') => 'bg-amber-500',
            $this->attributes->get('yellow') => 'bg-yellow-500',
            $this->attributes->get('lime') => 'bg-lime-500',
            $this->attributes->get('green') => 'bg-green-500',
            $this->attributes->get('emerald') => 'bg-emerald-500',
            $this->attributes->get('teal') => 'bg-teal-500',
            $this->attributes->get('cyan') => 'bg-cyan-500',
            $this->attributes->get('sky') => 'bg-sky-500',
            $this->attributes->get('blue') => 'bg-blue-500',
            $this->attributes->get('indigo') => 'bg-indigo-500',
            $this->attributes->get('violet') => 'bg-violet-500',
            $this->attributes->get('purple') => 'bg-purple-500',
            $this->attributes->get('fuchsia') => 'bg-fuchsia-500',
            $this->attributes->get('pink') => 'bg-pink-500',
            $this->attributes->get('rose') => 'bg-rose-500',
            default => 'bg-primary'
        };
    }

    public function sizeClasses(): string
    {
        $sizes = [
            'xs' => 'h-1',
            'sm' => 'h-2',
            'md' => 'h-3',
            'lg' => 'h-4',
            'xl' => 'h-5',
            '2xl' => 'h-6',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.progress.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
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
                <div class="w-full relative bg-gray-200 rounded-full dark:bg-gray-700 {{ $sizeClasses() }}">
                     <!-- Progress bar  -->
                    <div class="absolute inset-0 transition-all duration-300 rounded-full {{ $colorClasses() }}"
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
