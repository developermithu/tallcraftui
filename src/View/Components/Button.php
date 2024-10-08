<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
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

        // Button as link
        public ?string $link = null,
        public ?bool $external = false,
        public ?bool $noWireNavigate = false,

        // Button types
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

        // Button styles
        public bool $outline = false,
        public bool $flat = false,
        public bool $circle = false,

        // Button spinner
        public ?string $spinner = null,
        public ?bool $spinnerBars = false,
        public ?bool $spinnerDots = false,
        public ?bool $spinnerPulse = false,
    ) {}

    public function spinnerTarget(): ?string
    {
        return $this->spinner == 1 ? $this->attributes->whereStartsWith('wire:click')->first() : $this->spinner;
    }

    private function isPrimaryWithoutOthers(): bool
    {
        return $this->primary
            && ! $this->secondary
            && ! $this->black
            && ! $this->white
            && ! $this->slate
            && ! $this->gray
            && ! $this->zinc
            && ! $this->neutral
            && ! $this->stone
            && ! $this->red
            && ! $this->orange
            && ! $this->amber
            && ! $this->yellow
            && ! $this->lime
            && ! $this->green
            && ! $this->emerald
            && ! $this->teal
            && ! $this->cyan
            && ! $this->sky
            && ! $this->blue
            && ! $this->indigo
            && ! $this->violet
            && ! $this->purple
            && ! $this->fuchsia
            && ! $this->pink
            && ! $this->rose;
    }

    public function buttonBaseClasses(): string
    {
        return 'inline-flex gap-x-1.5 items-center border border-transparent w-fit justify-center font-semibold text-xs uppercase tracking-widest disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-200 dark:focus:ring-offset-0';
    }

    public function colorClasses(): string
    {
        $notOtherStyle = ! $this->outline && ! $this->flat;

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-primary/90 text-white hover:bg-primary focus:bg-primary focus:ring-primary',
            $this->secondary && $notOtherStyle => 'bg-secondary/90 text-white hover:bg-secondary focus:bg-secondary focus:ring-secondary',
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
            $this->emerald && $notOtherStyle => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:bg-emerald-700 focus:ring-emerald-500',
            $this->teal && $notOtherStyle => 'bg-teal-600 text-white hover:bg-teal-700 focus:bg-teal-700 focus:ring-teal-500',
            $this->cyan && $notOtherStyle => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:ring-cyan-500',
            $this->sky && $notOtherStyle => 'bg-sky-600 text-white hover:bg-sky-700 focus:bg-sky-700 focus:ring-sky-500',
            $this->blue && $notOtherStyle => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500',
            $this->indigo && $notOtherStyle => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:bg-indigo-700 focus:ring-indigo-500',
            $this->violet && $notOtherStyle => 'bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500',
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
            $this->outline && $this->isPrimaryWithoutOthers() => 'bg-transparent focus:border-transparent border-primary/40 dark:border-primary/90 text-primary/90 hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70',
            $this->outline && $this->secondary => 'bg-transparent focus:border-transparent border-secondary/40 dark:border-secondary/90 text-secondary/90 hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->outline && $this->black => 'bg-transparent focus:border-transparent border-black/20 dark:border-black/80 dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/60',
            $this->outline && $this->white => 'bg-transparent focus:border-transparent border-gray-200 dark:border-white text-black/20 dark:text-white/60 hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 dark:focus:ring-white/80 focus:ring-black/20',
            $this->outline && $this->slate => 'bg-transparent focus:border-transparent border-slate-300 dark:border-slate-600 text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->outline && $this->gray => 'bg-transparent focus:border-transparent border-gray-300 dark:border-gray-600 text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->outline && $this->zinc => 'bg-transparent focus:border-transparent border-zinc-300 dark:border-zinc-600 text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->outline && $this->neutral => 'bg-transparent focus:border-transparent border-neutral-300 dark:border-neutral-600 text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->outline && $this->stone => 'bg-transparent focus:border-transparent border-stone-300 dark:border-stone-600 text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->outline && $this->red => 'bg-transparent focus:border-transparent border-red-300 dark:border-red-600 text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->outline && $this->orange => 'bg-transparent focus:border-transparent border-orange-300 dark:border-orange-600 text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->outline && $this->amber => 'bg-transparent focus:border-transparent border-amber-300 dark:border-amber-600 text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->outline && $this->yellow => 'bg-transparent focus:border-transparent border-yellow-300 dark:border-yellow-600 text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->outline && $this->lime => 'bg-transparent focus:border-transparent border-lime-300 dark:border-lime-600 text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->outline && $this->green => 'bg-transparent focus:border-transparent border-green-300 dark:border-green-600 text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->outline && $this->emerald => 'bg-transparent focus:border-transparent border-emerald-300 dark:border-emerald-600 text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->outline && $this->teal => 'bg-transparent focus:border-transparent border-teal-300 dark:border-teal-600 text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->outline && $this->cyan => 'bg-transparent focus:border-transparent border-cyan-300 dark:border-cyan-600 text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->outline && $this->sky => 'bg-transparent focus:border-transparent border-sky-300 dark:border-sky-600 text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->outline && $this->blue => 'bg-transparent focus:border-transparent border-blue-300 dark:border-blue-600 text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->outline && $this->indigo => 'bg-transparent focus:border-transparent border-indigo-300 dark:border-indigo-600 text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->outline && $this->violet => 'bg-transparent focus:border-transparent border-violet-300 dark:border-violet-600 text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->outline && $this->purple => 'bg-transparent focus:border-transparent border-purple-300 dark:border-purple-600 text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->outline && $this->fuchsia => 'bg-transparent focus:border-transparent border-fuchsia-300 dark:border-fuchsia-600 text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->outline && $this->pink => 'bg-transparent focus:border-transparent border-pink-300 dark:border-pink-600 text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->outline && $this->rose => 'bg-transparent focus:border-transparent border-rose-300 dark:border-rose-600 text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }

    public function flatClasses(): string
    {
        return match (true) {
            $this->flat && $this->isPrimaryWithoutOthers() => 'bg-transparent text-primary hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70',
            $this->flat && $this->secondary => 'bg-transparent text-secondary hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->flat && $this->black => 'bg-transparent dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/80',
            $this->flat && $this->white => 'bg-transparent text-black/20 dark:text-white hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 focus:ring-black/20 dark:focus:ring-white/80',
            $this->flat && $this->slate => 'bg-transparent text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->flat && $this->gray => 'bg-transparent text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->flat && $this->zinc => 'bg-transparent text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->flat && $this->neutral => 'bg-transparent text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->flat && $this->stone => 'bg-transparent text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->flat && $this->red => 'bg-transparent text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->flat && $this->orange => 'bg-transparent text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->flat && $this->amber => 'bg-transparent text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->flat && $this->yellow => 'bg-transparent text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->flat && $this->lime => 'bg-transparent text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->flat && $this->green => 'bg-transparent text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->flat && $this->emerald => 'bg-transparent text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->flat && $this->teal => 'bg-transparent text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->flat && $this->cyan => 'bg-transparent text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->flat && $this->sky => 'bg-transparent text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->flat && $this->blue => 'bg-transparent text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->flat && $this->indigo => 'bg-transparent text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->flat && $this->violet => 'bg-transparent text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->flat && $this->purple => 'bg-transparent text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->flat && $this->fuchsia => 'bg-transparent text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->flat && $this->pink => 'bg-transparent text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->flat && $this->rose => 'bg-transparent text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }

    public function circleClasses(): string
    {
        $circleWithoutLabel = $this->circle && ! $this->label;

        return match (true) {
            $circleWithoutLabel && $this->attributes->get('sm') => 'rounded-full w-8 h-8 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('md') => 'rounded-full w-10 h-10 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('lg') => 'rounded-full w-12 h-12 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('xl') => 'rounded-full w-14 h-14 p-2 justify-center',
            $circleWithoutLabel => 'rounded-full w-10 h-10 p-2 justify-center', // md
            default => '',
        };
    }

    public function circleIconSize(): string
    {
        $circleWithoutLabel = $this->circle && ! $this->label;

        return match (true) {
            $circleWithoutLabel && $this->attributes->get('sm') => 'size-4',
            $circleWithoutLabel && $this->attributes->get('md') => 'size-5',
            $circleWithoutLabel && $this->attributes->get('lg') => 'size-6',
            $circleWithoutLabel && $this->attributes->get('xl') => 'size-7',
            default => 'size-5',
        };
    }

    public function sizeClasses(): string
    {
        $sizes = [
            'sm' => 'px-3 py-1.5',
            'md' => 'px-4 py-2',
            'lg' => 'px-5 py-2.5',
            'xl' => 'px-6 py-3',
            '2xl' => 'px-7 py-3.5',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.button.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('button', $this->attributes);
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
                    {{ $attributes->whereDoesntStartWith('class')->merge(['type' => 'submit']) }}
                @endif
                
                {{ $attributes->withoutTwMergeClasses()->twMerge([
                            $buttonBaseClasses(), 
                            $colorClasses(), 
                            $sizeClasses(), 
                            $outlineClasses(), 
                            $flatClasses(), 
                            $roundedClass(), 
                            $circleClasses(),
                        ]) 
                    }}
                >
                
                @if($icon)
                    <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', $circleIconSize()) }} />
                @elseif ($iconLeft)
                    <x-tc-icon :name="$iconLeft" {{ $attributes->twMergeFor('icon', $circleIconSize()) }} />
                @endif

                {{ $label ? __($label) : '' }}

                {{ $slot }}

                @if($iconRight && !$spinner)
                    <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', $circleIconSize()) }} />
                @endif

                @if($spinner)
                    @if($spinnerBars)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" bars xs />
                    @elseif($spinnerDots)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="fill-white/80" dots xs />
                    @elseif($spinnerPulse)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" pulse xs />
                    @else
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" xs />
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
