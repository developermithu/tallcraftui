<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        // Button content
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $iconClass = 'size-4',

        // Button as link
        public ?string $link = null,
        public ?bool $external = false,
        public ?bool $noWireNavigate = false,

        // Button colors
        public bool $primary = true,
        public bool $secondary = false,
        public bool $warning = false,
        public bool $info = false,
        public bool $success = false,
        public bool $danger = false,

        // Button styles
        public bool $outline = false,
        public bool $flat = false,
        public bool $circle = false,

        // Button spinner
        public ?string $spinner = null,
        public bool $spinnerBars = false,
        public bool $spinnerRing = false,
        public bool $spinnerDots = false,
        public bool $spinnerPulse = false,
    ) {}

    public function spinnerTarget(): ?string
    {
        return $this->spinner == 1 ? $this->attributes->whereStartsWith('wire:click')->first() : $this->spinner;
    }

    private function isPrimaryWithoutOthers(): bool
    {
        return $this->primary && ! $this->secondary && ! $this->danger && ! $this->warning && ! $this->info && ! $this->success;
    }

    public function buttonBaseClasses(): string
    {
        return 'inline-flex gap-x-1.5 items-center border border-transparent rounded font-semibold text-xs uppercase tracking-widest disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-200';
    }

    public function colorClasses(): string
    {
        $notOtherStyle = ! $this->outline && ! $this->flat;

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500  dark:focus:ring-offset-0',
            $this->secondary && $notOtherStyle => 'bg-gray-200 hover:bg-gray-300 focus:bg-gray-300 focus:ring-gray-500 dark:bg-gray-300 dark:hover:bg-gray-400 dark:focus:bg-gray-400 dark:focus:ring-gray-600 dark:focus:text-gray-900 dark:focus:ring-offset-0',
            $this->warning && $notOtherStyle => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500  dark:focus:ring-offset-0',
            $this->danger && $notOtherStyle => 'bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500 dark:focus:ring-offset-0',
            $this->success && $notOtherStyle => 'bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500  dark:focus:ring-offset-0',
            $this->info && $notOtherStyle => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500 dark:focus:ring-offset-0',
            default => '',
        };
    }

    public function outlineClasses(): string
    {
        return match (true) {
            $this->outline && $this->isPrimaryWithoutOthers() => 'bg-transparent border-violet-300 dark:border-violet-600 text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:border-transparent focus:ring-violet-500 dark:focus:ring-offset-0',
            $this->outline && $this->secondary => 'bg-transparent !border-gray-300 dark:!border-gray-400 text-gray-600 dark:text-gray-400 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:!border-transparent focus:ring-gray-500 dark:focus:ring-offset-0',
            $this->outline && $this->warning => 'bg-transparent border-yellow-300 dark:border-yellow-600 text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:border-transparent focus:ring-yellow-500 dark:focus:ring-offset-0',
            $this->outline && $this->success => 'bg-transparent border-green-300 dark:border-green-600 text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:border-transparent focus:ring-green-500 dark:focus:ring-offset-0',
            $this->outline && $this->danger => 'bg-transparent border-red-300 dark:border-red-600 text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:border-transparent focus:ring-red-500 dark:focus:ring-offset-0',
            $this->outline && $this->info => 'bg-transparent border-blue-300 dark:border-blue-600 text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:border-transparent focus:ring-blue-500 dark:focus:ring-offset-0',
            default => '',
        };
    }

    public function flatClasses(): string
    {
        return match (true) {
            $this->flat && $this->isPrimaryWithoutOthers() => 'bg-transparent text-violet-600  hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500 dark:focus:ring-offset-0',
            $this->flat && $this->secondary => 'bg-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500 dark:focus:ring-offset-0',
            $this->flat && $this->warning => 'bg-transparent text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500 dark:focus:ring-offset-0',
            $this->flat && $this->success => 'bg-transparent text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500 dark:focus:ring-offset-0',
            $this->flat && $this->danger => 'bg-transparent text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500 dark:focus:ring-offset-0',
            $this->flat && $this->info => 'bg-transparent text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500 dark:focus:ring-offset-0',
            default => '',
        };
    }

    public function circleClasses(): string
    {
        $circleWithoutLabel = $this->circle && ! $this->label;

        return match (true) {
            $circleWithoutLabel => 'rounded-full w-10 h-10 justify-center',
            $circleWithoutLabel && $this->attributes->get('sm') => 'rounded-full w-8 h-8 justify-center',
            $circleWithoutLabel && $this->attributes->get('lg') => 'rounded-full w-12 h-12 justify-center',
            $circleWithoutLabel && $this->attributes->get('xl') => 'rounded-full w-14 h-14 justify-center',
            default => '',
        };
    }

    public function sizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'px-3 py-1.5',
            $this->attributes->get('lg') => 'px-5 py-2.5',
            $this->attributes->get('xl') => 'px-6 py-3',
            $this->attributes->get('xxl') => 'px-7 py-3.5',
            default => 'px-4 py-2',
        };
    }

    public function getSpinner(): string
    {
        return match (true) {
            $this->spinnerBars => '<svg wire:loading wire:target="'.$this->spinnerTarget().'" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.25s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.15s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.3s" dur="0.75s" values="1;0.2"/></rect></svg>',

            $this->spinnerRing => '<svg wire:loading wire:target="'.$this->spinnerTarget().'" class="w-4 h-4 text-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>',

            $this->spinnerPulse => '<svg wire:loading wire:target="'.$this->spinnerTarget().'" class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse30" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse31" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse32" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg>',

            default => '<svg wire:loading wire:target="'.$this->spinnerTarget().'" class="w-4 h-4 fill-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>', //  Default dots spinner
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if($link)
                <a href="{{ $link }}"
            @else
                <button 
            @endif

                @if($link && $external)
                    target="_blank"
                @endif

                @if($link && !$external && !$noWireNavigate)
                    wire:navigate
                @endif
                    
                @if(!$link)
                    wire:loading.attr="disabled" wire:target="{{ $spinnerTarget() }}"
                    {{ $attributes->merge(['type' => 'submit']) }}
                @endif
                
                {{ $attributes->class([
                        $buttonBaseClasses(), 
                        $colorClasses(), 
                        $sizeClasses(), 
                        $outlineClasses(), 
                        $flatClasses(), 
                        $circleClasses(),
                ]) }}>
                
                @if($icon)
                    <x-icon :name="$icon" :class="$iconClass" />
                @elseif ($iconLeft)
                    <x-icon :name="$iconLeft" :class="$iconClass" />
                @endif

                {{ $label ? __($label) : '' }}

                {{ $slot }}

                @if($iconRight && !$spinner)
                    <x-icon :name="$iconRight" :class="$iconClass" />
                @endif

                @if($spinner)
                    {!! $getSpinner() !!}
                @endif

            @if($link)
                </a>
            @else
                </button>
            @endif
        HTML;
    }
}
