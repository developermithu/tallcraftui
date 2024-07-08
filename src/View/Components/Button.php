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
    ) {
    }

    public function spinnerTarget(): ?string
    {
        if ($this->spinner == 1) {
            return $this->attributes->whereStartsWith('wire:click')->first();
        }

        return $this->spinner;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if($link)
                <a href="{{ $link }}"
            @else
                <button 
            @endif
            
                @php 
                    $sm = $attributes->get('sm');
                    $lg = $attributes->get('lg');
                    $xl = $attributes->get('xl');
                    $xxl = $attributes->get('xxl');
                    $md = $attributes->get('md') || (!$sm && !$lg && !$xl && !$xxl);
                @endphp

                @if($link && $external)
                    target="_blank"
                @endif

                @if($link && !$external && !$noWireNavigate)
                    wire:navigate
                @endif
                    
                @if(!$link)
                    wire:loading.attr="disabled" wire:target="{{ $spinnerTarget() }}"
                    {{ $attributes
                        ->merge(['type' => 'submit'])
                    }}
                @endif
                
                {{ $attributes
                    ->class([
                        "inline-flex gap-x-1.5 items-center dark:bg-gray-200 border border-transparent rounded font-semibold text-xs text-gray-600 uppercase tracking-widest disabled:opacity-50 disabled:pointer-events-none dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150",
                        
                        "bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500 active:bg-violet-800" => $primary && !$flat && !$outline && !$secondary && !$danger && !$warning && !$info && !$success,
                        "bg-gray-200 hover:bg-gray-300 focus:ring-gray-500" => $secondary && !$flat && !$outline,
                        "bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500 active:bg-yellow-800" => $warning && !$flat && !$outline,
                        "bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500 active:bg-red-800" => $danger && !$flat && !$outline,
                        "bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500 active:bg-green-800" => $success && !$flat && !$outline,
                        "bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500 active:bg-blue-800" => $info && !$flat && !$outline,

                        "!bg-transparent" => $outline,
                        "!border-violet-300 text-violet-600 hover:bg-violet-100 focus:bg-violet-100 active:bg-violet-100 focus:ring-violet-500" => ($outline && $primary) && !$secondary && !$danger && !$warning && !$info && !$success,
                        "!border-gray-300 text-gray-600 hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 focus:ring-gray-500" => $outline && $secondary,
                        "!border-yellow-300 text-yellow-600 hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-100 focus:ring-yellow-500" => $outline && $warning,
                        "!border-green-300 text-green-600 hover:bg-green-100 focus:bg-green-100 active:bg-green-100 focus:ring-green-500" => $outline && $success,
                        "!border-red-300 text-red-600 hover:bg-red-100 focus:bg-red-100 active:bg-red-100 focus:ring-red-500" => $outline && $danger,
                        "!border-blue-300 text-blue-600 hover:bg-blue-100 focus:bg-blue-100 active:bg-blue-100 focus:ring-blue-500" => $outline && $info,

                        "!bg-transparent" => $flat,
                        "text-violet-600 hover:bg-violet-100 focus:bg-violet-100 active:bg-violet-100 focus:ring-violet-500" => ($flat && $primary) && !$secondary && !$danger && !$warning && !$info && !$success,
                        "text-gray-600 hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 focus:ring-gray-500" => $flat && $secondary,
                        "text-yellow-600 hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-100 focus:ring-yellow-500" => $flat && $warning,
                        "text-green-600 hover:bg-green-100 focus:bg-green-100 active:bg-green-100 focus:ring-green-500" => $flat && $success,
                        "text-red-600 hover:bg-red-100 focus:bg-red-100 active:bg-red-100 focus:ring-red-500" => $flat && $danger,
                        "text-blue-600 hover:bg-blue-100 focus:bg-blue-100 active:bg-blue-100 focus:ring-blue-500" => $flat && $info,

                        "px-3 py-1.5" => $sm,
                        "px-4 py-2" => $md,
                        "px-5 py-2.5" => $lg,
                        "px-6 py-3" => $xl,
                        "px-7 py-3.5" => $xxl,

                        "rounded-full" => $circle,
                        "rounded-full w-10 h-10 justify-center" => $circle && !$label,
                        "rounded-full w-8 h-8 justify-center" => $circle && $sm && !$label,
                        "rounded-full w-12 h-12 justify-center" => $circle && $lg && !$label,
                        "rounded-full w-14 h-14 justify-center" => $circle && $xl && !$label,
                    ])
                }}
            >
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
                    @if($spinnerBars)
                        <svg wire:loading wire:target="{{ $spinnerTarget() }}" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.25s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.15s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.3s" dur="0.75s" values="1;0.2"/></rect></svg>
                    @elseif($spinnerRing)
                        <svg wire:loading wire:target="{{ $spinnerTarget() }}" class="w-4 h-4 text-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>
                    @elseif($spinnerPulse)
                        <svg wire:loading wire:target="{{ $spinnerTarget() }}" class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse30" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse31" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse32" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg>
                    @else
                        <!-- Spinner Dots -->
                        <svg wire:loading wire:target="{{ $spinnerTarget() }}" class="w-4 h-4 fill-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>
                    @endif
                @endif

            @if($link)
                </a>
            @else
                </button>
            @endif
        HTML;
    }
}
