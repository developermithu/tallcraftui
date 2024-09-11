<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Spinner extends Component
{
    public function __construct(
        public ?bool $bars = false,
        public ?bool $dots = false,
        public ?bool $pulse = false,

        public bool $primary = true,
        public bool $secondary = false,
        public bool $black = false,
        public bool $white = false,
        public bool $slate = false,
        public bool $gray = false,
        public bool $zinc = false,
        public bool $neutral = false,
        public bool $stone = false,
        public bool $red = false,
        public bool $orange = false,
        public bool $amber = false,
        public bool $yellow = false,
        public bool $lime = false,
        public bool $green = false,
        public bool $emerald = false,
        public bool $teal = false,
        public bool $cyan = false,
        public bool $sky = false,
        public bool $blue = false,
        public bool $indigo = false,
        public bool $violet = false,
        public bool $purple = false,
        public bool $fuchsia = false,
        public bool $pink = false,
        public bool $rose = false,

        // Sizes
        public ?bool $xs = false,
        public ?bool $sm = false,
        public ?bool $md = false,
        public ?bool $lg = false,
        public ?bool $xl = false,
    ) {}

    public function spinnerColors(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary',
            $this->black => 'text-gray-900',
            $this->white => 'text-white',
            $this->slate => 'text-slate-500',
            $this->gray => 'text-gray-500',
            $this->zinc => 'text-zinc-500',
            $this->neutral => 'text-neutral-500',
            $this->stone => 'text-stone-500',
            $this->red => 'text-red-500',
            $this->orange => 'text-orange-500',
            $this->amber => 'text-amber-500',
            $this->yellow => 'text-yellow-500',
            $this->lime => 'text-lime-500',
            $this->green => 'text-green-500',
            $this->emerald => 'text-emerald-500',
            $this->teal => 'text-teal-500',
            $this->cyan => 'text-cyan-500',
            $this->sky => 'text-sky-500',
            $this->blue => 'text-blue-500',
            $this->indigo => 'text-indigo-500',
            $this->violet => 'text-violet-500',
            $this->purple => 'text-purple-500',
            $this->fuchsia => 'text-fuchsia-500',
            $this->pink => 'text-pink-500',
            $this->rose => 'text-rose-500',
            default => 'text-primary',
        };
    }

    public function sizes(): string
    {
        return match (true) {
            $this->xs => 'w-4 h-4',
            $this->sm => 'w-6 h-6',
            $this->md => 'w-8 h-8',
            $this->lg => 'w-10 h-10',
            $this->xl => 'w-12 h-12',
            default => 'w-8 h-8', // md
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if($bars)
                <svg {{ $attributes->twMerge([$spinnerColors(), $sizes()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.25s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.15s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.3s" dur="0.75s" values="1;0.2"/></rect></svg>
            @elseif($pulse)
                <svg {{ $attributes->twMerge([$spinnerColors(), $sizes()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse30" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse31" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse32" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg>
            @elseif($dots)
                <svg {{ $attributes->twMerge(['animate-spin', str_replace('text-', 'fill-', $spinnerColors()), $sizes()]) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>
            @else
                <svg {{ $attributes->twMerge(['animate-spin', $spinnerColors(), $sizes()]) }} xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>
            @endif
        HTML;
    }
}
