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

        // Tailwind Colors 
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
        public bool $cyan = false,
        public bool $sky = false,
        public bool $purple = false,
        public bool $fuchsia = false,
        public bool $pink = false,
        public bool $rose = false,

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
        return $this->spinner == 1 ? $this->attributes->whereStartsWith('wire:click')->first() : $this->spinner;
    }

    private function isPrimaryWithoutOthers(): bool
    {
        return $this->primary
            && !$this->secondary
            && !$this->danger
            && !$this->warning
            && !$this->info
            && !$this->success

            && !$this->black
            && !$this->white
            && !$this->slate
            && !$this->gray
            && !$this->zinc
            && !$this->neutral
            && !$this->stone
            && !$this->red
            && !$this->orange
            && !$this->amber
            && !$this->yellow
            && !$this->lime
            && !$this->green
            && !$this->cyan
            && !$this->sky
            && !$this->purple
            && !$this->fuchsia
            && !$this->pink
            && !$this->rose;
    }

    public function buttonBaseClasses(): string
    {
        return 'inline-flex gap-x-1.5 items-center border border-transparent rounded font-semibold text-xs uppercase tracking-widest disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-200 dark:focus:ring-offset-0';
    }

    public function colorClasses(): string
    {
        $notOtherStyle = !$this->outline && !$this->flat;

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500',
            $this->secondary && $notOtherStyle => 'bg-gray-200 hover:bg-gray-300 focus:bg-gray-300 focus:ring-gray-500 dark:bg-gray-300 dark:hover:bg-gray-400 dark:focus:bg-gray-400 dark:focus:ring-gray-600 dark:focus:text-gray-900',
            $this->warning && $notOtherStyle => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500',
            $this->danger && $notOtherStyle => 'bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500',
            $this->success && $notOtherStyle => 'bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500',
            $this->info && $notOtherStyle => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500',

            $this->black && $notOtherStyle => 'bg-black text-white hover:bg-black/90 focus:bg-black/90 focus:ring-black/70',
            $this->white && $notOtherStyle => 'bg-black/5 dark:bg-white text-gray-500 dark:text-gray-700 hover:bg-black/10 dark:hover:bg-white/90 focus:bg-black/15 dark:focus:bg-white/90 focus:ring-black/20 dark:focus:ring-white/70',
            $this->slate && $notOtherStyle => 'bg-slate-600 text-white hover:bg-slate-700 focus:bg-slate-700 focus:ring-slate-500',
            $this->gray && $notOtherStyle => 'bg-gray-600 text-white hover:bg-gray-700 focus:bg-gray-700 focus:ring-gray-500',
            $this->zinc && $notOtherStyle => 'bg-zinc-600 text-white hover:bg-zinc-700 focus:bg-zinc-700 focus:ring-zinc-500',
            $this->neutral && $notOtherStyle => 'bg-neutral-600 text-white hover:bg-neutral-700 focus:bg-neutral-700 focus:ring-neutral-500',
            $this->stone && $notOtherStyle => 'bg-stone-600 text-white hover:bg-stone-700 focus:bg-stone-700 focus:ring-stone-500',
            $this->red && $notOtherStyle => 'bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500',
            $this->orange && $notOtherStyle => 'bg-orange-600 text-white hover:bg-orange-700 focus:bg-orange-700 focus:ring-orange-500',
            $this->amber && $notOtherStyle => 'bg-amber-600 text-white hover:bg-amber-700 focus:bg-amber-700 focus:ring-amber-500',
            $this->yellow && $notOtherStyle => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500',
            $this->lime && $notOtherStyle => 'bg-lime-600 text-white hover:bg-lime-700 focus:bg-lime-700 focus:ring-lime-500',
            $this->green && $notOtherStyle => 'bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500',
            $this->cyan && $notOtherStyle => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:ring-cyan-500',
            $this->sky && $notOtherStyle => 'bg-sky-600 text-white hover:bg-sky-700 focus:bg-sky-700 focus:ring-sky-500',
            $this->purple && $notOtherStyle => 'bg-purple-600 text-white hover:bg-purple-700 focus:bg-purple-700 focus:ring-purple-500',
            $this->fuchsia && $notOtherStyle => 'bg-fuchsia-600 text-white hover:bg-fuchsia-700 focus:bg-fuchsia-700 focus:ring-fuchsia-500',
            $this->pink && $notOtherStyle => 'bg-pink-600 text-white hover:bg-pink-700 focus:bg-pink-700 focus:ring-pink-500',
            $this->rose && $notOtherStyle => 'bg-rose-600 text-white hover:bg-rose-700 focus:bg-rose-700 focus:ring-rose-500',
            default => '',
        };
    }

    public function outlineClasses(): string
    {
        return match (true) {
            $this->outline && $this->isPrimaryWithoutOthers() => '!border-violet-300 dark:!border-violet-600 text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->outline && $this->secondary => '!border-gray-300 dark:!border-gray-400 text-gray-600 dark:text-gray-400 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:!border-transparent focus:ring-gray-500',
            $this->outline && $this->warning => '!border-yellow-300 dark:!border-yellow-600 text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->outline && $this->success => '!border-green-300 dark:!border-green-600 text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->outline && $this->danger => '!border-red-300 dark:!border-red-600 text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->outline && $this->info => '!border-blue-300 dark:!border-blue-600 text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',

            $this->outline && $this->black => '!border-black/20 dark:!border-black/80 dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/60',
            $this->outline && $this->white => '!border-gray-200 dark:!border-white text-black/20 dark:text-white/60 hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 dark:focus:ring-white/80 focus:ring-black/20',
            $this->outline && $this->slate => '!border-slate-300 dark:!border-slate-600 text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->outline && $this->gray => '!border-gray-300 dark:!border-gray-600 text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->outline && $this->zinc => '!border-zinc-300 dark:!border-zinc-600 text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->outline && $this->neutral => '!border-neutral-300 dark:!border-neutral-600 text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->outline && $this->stone => '!border-stone-300 dark:!border-stone-600 text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->outline && $this->red => '!border-red-300 dark:!border-red-600 text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->outline && $this->orange => '!border-orange-300 dark:!border-orange-600 text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->outline && $this->amber => '!border-amber-300 dark:!border-amber-600 text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->outline && $this->yellow => '!border-yellow-300 dark:!border-yellow-600 text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->outline && $this->lime => '!border-lime-300 dark:!border-lime-600 text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->outline && $this->green => '!border-green-300 dark:!border-green-600 text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->outline && $this->cyan => '!border-cyan-300 dark:!border-cyan-600 text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->outline && $this->sky => '!border-sky-300 dark:!border-sky-600 text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->outline && $this->purple => '!border-purple-300 dark:!border-purple-600 text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->outline && $this->fuchsia => '!border-fuchsia-300 dark:!border-fuchsia-600 text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->outline && $this->pink => '!border-pink-300 dark:!border-pink-600 text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->outline && $this->rose => '!border-rose-300 dark:!border-rose-600 text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }

    public function flatClasses(): string
    {
        return match (true) {
            $this->flat && $this->isPrimaryWithoutOthers() => 'text-violet-600  hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->flat && $this->secondary => 'text-gray-600 dark:text-gray-400 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->flat && $this->warning => 'text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->flat && $this->success => 'text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->flat && $this->danger => 'text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->flat && $this->info => 'text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',

            $this->flat && $this->black => 'dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/80',
            $this->flat && $this->white => 'text-black/20 dark:text-white hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 focus:ring-black/20 dark:focus:ring-white/80',
            $this->flat && $this->slate => 'text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->flat && $this->gray => 'text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->flat && $this->zinc => 'text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->flat && $this->neutral => 'text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->flat && $this->stone => 'text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->flat && $this->red => 'text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->flat && $this->orange => 'text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->flat && $this->amber => 'text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->flat && $this->yellow => 'text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->flat && $this->lime => 'text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->flat && $this->green => 'text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->flat && $this->cyan => 'text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->flat && $this->sky => 'text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->flat && $this->purple => 'text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->flat && $this->fuchsia => 'text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->flat && $this->pink => 'text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->flat && $this->rose => 'text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }

    public function circleClasses(): string
    {
        $circleWithoutLabel = $this->circle && !$this->label;

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
            $this->spinnerBars => '<svg wire:loading wire:target="' . $this->spinnerTarget() . '" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><rect width="6" height="14" x="1" y="4" fill="currentColor"><animate id="svgSpinnersBarsFade0" fill="freeze" attributeName="opacity" begin="0;svgSpinnersBarsFade1.end-0.25s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="9" y="4" fill="currentColor" opacity="0.4"><animate fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.15s" dur="0.75s" values="1;0.2"/></rect><rect width="6" height="14" x="17" y="4" fill="currentColor" opacity="0.3"><animate id="svgSpinnersBarsFade1" fill="freeze" attributeName="opacity" begin="svgSpinnersBarsFade0.begin+0.3s" dur="0.75s" values="1;0.2"/></rect></svg>',

            $this->spinnerRing => '<svg wire:loading wire:target="' . $this->spinnerTarget() . '" class="w-4 h-4 text-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity="0.25"/><path fill="currentColor" d="M10.72,19.9a8,8,0,0,1-6.5-9.79A7.77,7.77,0,0,1,10.4,4.16a8,8,0,0,1,9.49,6.52A1.54,1.54,0,0,0,21.38,12h.13a1.37,1.37,0,0,0,1.38-1.54,11,11,0,1,0-12.7,12.39A1.54,1.54,0,0,0,12,21.34h0A1.47,1.47,0,0,0,10.72,19.9Z" transform="rotate(360 12 12)"/></svg>',

            $this->spinnerPulse => '<svg wire:loading wire:target="' . $this->spinnerTarget() . '" class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse30" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse32.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse31" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.4s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse32" fill="freeze" attributeName="r" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse30.begin+0.8s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg>',

            default => '<svg wire:loading wire:target="' . $this->spinnerTarget() . '" class="w-4 h-4 fill-white/80 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>', //  Default dots spinner
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
                        "bg-transparent" => $outline || $flat,
                        "focus:!border-transparent" => $outline,
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
