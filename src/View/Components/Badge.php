<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,

        // Badge types
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

        // Badge styles
        public bool $outline = false,
    ) {}

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

    public function colorClasses(): string
    {
        $notOtherStyle = ! $this->outline;

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-primary/10 text-primary',
            $this->secondary && $notOtherStyle => 'bg-secondary/10 text-secondary',
            $this->black && $notOtherStyle => 'bg-black text-white',
            $this->white && $notOtherStyle => 'bg-gray-50 text-gray-700',
            $this->slate && $notOtherStyle => 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-400',
            $this->gray && $notOtherStyle => 'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
            $this->zinc && $notOtherStyle => 'bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-400',
            $this->neutral && $notOtherStyle => 'bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-400',
            $this->stone && $notOtherStyle => 'bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-400',
            $this->red && $notOtherStyle => 'bg-red-200 dark:bg-red-800/50 text-red-700 dark:text-red-500',
            $this->orange && $notOtherStyle => 'bg-orange-200 dark:bg-orange-800/50 text-orange-700 dark:text-orange-500',
            $this->amber && $notOtherStyle => 'bg-amber-200 dark:bg-amber-800/50 text-amber-700 dark:text-amber-500',
            $this->yellow && $notOtherStyle => 'bg-yellow-200 dark:bg-yellow-800/50 text-yellow-700 dark:text-yellow-500',
            $this->lime && $notOtherStyle => 'bg-lime-200 dark:bg-lime-800/50 text-lime-700 dark:text-lime-500',
            $this->green && $notOtherStyle => 'bg-green-200 dark:bg-green-800/50 text-green-700 dark:text-green-500',
            $this->emerald && $notOtherStyle => 'bg-emerald-200 dark:bg-emerald-800/50 text-emerald-700 dark:text-emerald-500',
            $this->teal && $notOtherStyle => 'bg-teal-200 dark:bg-teal-800/50 text-teal-700 dark:text-teal-500',
            $this->cyan && $notOtherStyle => 'bg-cyan-200 dark:bg-cyan-800/50 text-cyan-700 dark:text-cyan-500',
            $this->sky && $notOtherStyle => 'bg-sky-200 dark:bg-sky-800/50 text-sky-700 dark:text-sky-500',
            $this->blue && $notOtherStyle => 'bg-blue-200 dark:bg-blue-800/50 text-blue-700 dark:text-blue-500',
            $this->indigo && $notOtherStyle => 'bg-indigo-200 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-500',
            $this->violet && $notOtherStyle => 'bg-violet-200 dark:bg-violet-800/50 text-violet-700 dark:text-violet-500',
            $this->purple && $notOtherStyle => 'bg-purple-200 dark:bg-purple-800/50 text-purple-700 dark:text-purple-500',
            $this->fuchsia && $notOtherStyle => 'bg-fuchsia-200 dark:bg-fuchsia-800/50 text-fuchsia-700 dark:text-fuchsia-500',
            $this->pink && $notOtherStyle => 'bg-pink-200 dark:bg-pink-800/50 text-pink-700 dark:text-pink-500',
            $this->rose && $notOtherStyle => 'bg-rose-200 dark:bg-rose-800/50 text-rose-700 dark:text-rose-500',
            default => '',
        };
    }

    public function outlineClasses(): string
    {
        return match (true) {
            $this->outline && $this->isPrimaryWithoutOthers() => 'bg-transparent text-primary border border-primary',
            $this->outline && $this->secondary => 'bg-transparent text-secondary border border-secondary',
            $this->outline && $this->black => 'bg-transparent text-black border border-black',
            $this->outline && $this->white => 'bg-transparent text-gray-600 dark:text-white border border-gray-200 dark:border-white',
            $this->outline && $this->slate => 'bg-transparent text-slate-600 dark:text-slate-400 border border-slate-500 dark:border-slate-400',
            $this->outline && $this->gray => 'bg-transparent text-gray-600 dark:text-gray-400 border border-gray-500 dark:border-gray-400',
            $this->outline && $this->zinc => 'bg-transparent text-zinc-600 dark:text-zinc-400 border border-zinc-500 dark:border-zinc-400',
            $this->outline && $this->neutral => 'bg-transparent text-neutral-600 dark:text-neutral-400 border border-neutral-500 dark:border-neutral-400',
            $this->outline && $this->stone => 'bg-transparent text-stone-600 dark:text-stone-400 border border-stone-500 dark:border-stone-400',
            $this->outline && $this->red => 'bg-transparent text-red-600 border border-red-500',
            $this->outline && $this->orange => 'bg-transparent text-orange-600 border border-orange-500',
            $this->outline && $this->amber => 'bg-transparent text-amber-600 border border-amber-500',
            $this->outline && $this->yellow => 'bg-transparent text-yellow-600 border border-yellow-500',
            $this->outline && $this->lime => 'bg-transparent text-lime-600 border border-lime-500',
            $this->outline && $this->green => 'bg-transparent text-green-600 border border-green-500',
            $this->outline && $this->emerald => 'bg-transparent text-emerald-600 border border-emerald-500',
            $this->outline && $this->teal => 'bg-transparent text-teal-600 border border-teal-500',
            $this->outline && $this->cyan => 'bg-transparent text-cyan-600 border border-cyan-500',
            $this->outline && $this->sky => 'bg-transparent text-sky-600 border border-sky-500',
            $this->outline && $this->blue => 'bg-transparent text-blue-600 border border-blue-500',
            $this->outline && $this->indigo => 'bg-transparent text-indigo-600 border border-indigo-500',
            $this->outline && $this->violet => 'bg-transparent text-violet-600 border border-violet-500',
            $this->outline && $this->purple => 'bg-transparent text-purple-600 border border-purple-500',
            $this->outline && $this->fuchsia => 'bg-transparent text-fuchsia-600 border border-fuchsia-500',
            $this->outline && $this->pink => 'bg-transparent text-pink-600 border border-pink-500',
            $this->outline && $this->rose => 'bg-transparent text-rose-600 border border-rose-500',
            default => '',
        };
    }

    public function badgeSize(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'text-xs px-1.5',
            $this->attributes->get('md') => 'text-xs px-2 py-0.5',
            $this->attributes->get('lg') => 'text-sm px-2.5 py-1',
            $this->attributes->get('xl') => 'text-base px-3 py-1.5',
            $this->attributes->get('2xl') => 'text-lg px-3.5 py-2',
            default => 'text-xs px-2 py-0.5',
        };
    }

    public function iconSize(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'size-3',
            $this->attributes->get('md') => 'size-3',
            $this->attributes->get('lg') => 'size-3.5',
            $this->attributes->get('xl') => 'size-4',
            $this->attributes->get('2xl') => 'size-[18px]',
            default => 'size-3',
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('badge', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <span {{ $attributes->withoutTwMergeClasses()->twMerge([
                            "inline-flex gap-x-1 w-fit items-center justify-center font-semibold",
                            $badgeSize(), 
                            $colorClasses(), 
                            $outlineClasses(),
                            $roundedClass(),
                        ]) 
                    }}
                >
                @if($icon)
                    <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', $iconSize()) }} />
                @elseif ($iconLeft)
                    <x-tc-icon :name="$iconLeft" {{ $attributes->twMergeFor('icon', $iconSize()) }} />
                @endif

                {{ __($label) }}

                @if($iconRight)
                    <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', $iconSize()) }} />
                @endif
            </span>
        HTML;
    }
}
