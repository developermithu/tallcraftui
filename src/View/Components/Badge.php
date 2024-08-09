<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,

        // Badge colors
        public bool $primary = true,
        public bool $secondary = false,
        public bool $tertiary = false,
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
            && ! $this->tertiary
            && ! $this->danger
            && ! $this->warning
            && ! $this->info
            && ! $this->success

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
            $this->tertiary && $notOtherStyle => 'bg-tertiary/10 text-tertiary',
            $this->warning && $notOtherStyle => 'bg-warning/10 text-warning',
            $this->info && $notOtherStyle => 'bg-info/10 text-info',
            $this->danger && $notOtherStyle => 'bg-danger/10 text-danger',
            $this->success && $notOtherStyle => 'bg-success/10 text-success',

            // Tailwind Colors
            $this->black && $notOtherStyle => 'bg-black text-white',
            $this->white && $notOtherStyle => 'bg-gray-50 text-gray-700',
            $this->slate && $notOtherStyle => 'bg-slate-100 dark:bg-slate-800/50 dark:text-slate-400 text-slate-800',
            $this->gray && $notOtherStyle => 'bg-gray-100 dark:bg-gray-800/50 dark:text-gray-400 text-gray-800',
            $this->zinc && $notOtherStyle => 'bg-zinc-100 dark:bg-zinc-800/50 dark:text-zinc-400 text-zinc-800',
            $this->neutral && $notOtherStyle => 'bg-neutral-100 dark:bg-neutral-800/50 dark:text-neutral-400 text-neutral-800',
            $this->stone && $notOtherStyle => 'bg-stone-100 dark:bg-stone-800/50 dark:text-stone-400 text-stone-800',
            $this->red && $notOtherStyle => 'bg-red-100 dark:bg-red-800/10 text-red-800',
            $this->orange && $notOtherStyle => 'bg-orange-100 dark:bg-orange-800/10 text-orange-800',
            $this->amber && $notOtherStyle => 'bg-amber-100 dark:bg-amber-800/10 text-amber-800',
            $this->yellow && $notOtherStyle => 'bg-yellow-100 dark:bg-yellow-800/10 text-yellow-800',
            $this->lime && $notOtherStyle => 'bg-lime-100 dark:bg-lime-800/10 text-lime-800',
            $this->green && $notOtherStyle => 'bg-green-100 dark:bg-green-800/10 text-green-800',
            $this->emerald && $notOtherStyle => 'bg-emerald-100 dark:bg-emerald-800/10 text-emerald-800',
            $this->teal && $notOtherStyle => 'bg-teal-100 dark:bg-teal-800/10 text-teal-800',
            $this->cyan && $notOtherStyle => 'bg-cyan-100 dark:bg-cyan-800/10 text-cyan-800',
            $this->sky && $notOtherStyle => 'bg-sky-100 dark:bg-sky-800/10 text-sky-800',
            $this->blue && $notOtherStyle => 'bg-blue-100 dark:bg-blue-800/10 text-blue-800',
            $this->indigo && $notOtherStyle => 'bg-indigo-100 dark:bg-indigo-800/10 text-indigo-800',
            $this->violet && $notOtherStyle => 'bg-violet-100 dark:bg-violet-800/10 text-violet-800',
            $this->purple && $notOtherStyle => 'bg-purple-100 dark:bg-purple-800/10 text-purple-800',
            $this->fuchsia && $notOtherStyle => 'bg-fuchsia-100 dark:bg-fuchsia-800/10 text-fuchsia-800',
            $this->pink && $notOtherStyle => 'bg-pink-100 dark:bg-pink-800/10 text-pink-800',
            $this->rose && $notOtherStyle => 'bg-rose-100 dark:bg-rose-800/10 text-rose-800',
            default => '',
        };
    }

    public function outlineClasses(): string
    {
        return match (true) {
            $this->outline && $this->isPrimaryWithoutOthers() => 'bg-transparent text-primary border border-primary',
            $this->outline && $this->secondary => 'bg-transparent text-secondary border border-secondary',
            $this->outline && $this->tertiary => 'bg-transparent text-tertiary border border-tertiary',
            $this->outline && $this->warning => 'bg-transparent text-warning border border-warning',
            $this->outline && $this->success => 'bg-transparent text-success border border-success',
            $this->outline && $this->danger => 'bg-transparent text-danger border border-danger',
            $this->outline && $this->info => 'bg-transparent text-info border border-info',

            $this->outline && $this->black => 'bg-transparent text-black border border-black',
            $this->outline && $this->white => 'bg-transparent text-gray-500 border border-gray-200',
            $this->outline && $this->slate => 'bg-transparent text-slate-500 border border-slate-500',
            $this->outline && $this->gray => 'bg-transparent text-gray-500 border border-gray-500',
            $this->outline && $this->zinc => 'bg-transparent text-zinc-500 border border-zinc-500',
            $this->outline && $this->neutral => 'bg-transparent text-neutral-500 border border-neutral-500',
            $this->outline && $this->stone => 'bg-transparent text-stone-500 border border-stone-500',
            $this->outline && $this->red => 'bg-transparent text-red-500 border border-red-500',
            $this->outline && $this->orange => 'bg-transparent text-orange-500 border border-orange-500',
            $this->outline && $this->amber => 'bg-transparent text-amber-500 border border-amber-500',
            $this->outline && $this->yellow => 'bg-transparent text-yellow-500 border border-yellow-500',
            $this->outline && $this->lime => 'bg-transparent text-lime-500 border border-lime-500',
            $this->outline && $this->green => 'bg-transparent text-green-500 border border-green-500',
            $this->outline && $this->emerald => 'bg-transparent text-emerald-500 border border-emerald-500',
            $this->outline && $this->teal => 'bg-transparent text-teal-500 border border-teal-500',
            $this->outline && $this->cyan => 'bg-transparent text-cyan-500 border border-cyan-500',
            $this->outline && $this->sky => 'bg-transparent text-sky-500 border border-sky-500',
            $this->outline && $this->blue => 'bg-transparent text-blue-500 border border-blue-500',
            $this->outline && $this->indigo => 'bg-transparent text-indigo-500 border border-indigo-500',
            $this->outline && $this->violet => 'bg-transparent text-violet-500 border border-violet-500',
            $this->outline && $this->purple => 'bg-transparent text-purple-500 border border-purple-500',
            $this->outline && $this->fuchsia => 'bg-transparent text-fuchsia-500 border border-fuchsia-500',
            $this->outline && $this->pink => 'bg-transparent text-pink-500 border border-pink-500',
            $this->outline && $this->rose => 'bg-transparent text-rose-500 border border-rose-500',
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

    public function roundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-none',
            $this->attributes->get('rounded') => 'rounded',
            $this->attributes->get('rounded-sm') => 'rounded-sm',
            $this->attributes->get('rounded-md') => 'rounded-md',
            $this->attributes->get('rounded-lg') => 'rounded-lg',
            $this->attributes->get('rounded-xl') => 'rounded-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-3xl',
            $this->attributes->get('rounded-full') => 'rounded-full',
            default => 'rounded',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <span {{ $attributes->withoutTwMergeClasses()->twMerge([
                            "inline-flex gap-x-1 w-fit items-center font-semibold",
                            $badgeSize(), 
                            $colorClasses(), 
                            $outlineClasses(),
                            $roundClasses(),
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
