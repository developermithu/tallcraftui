<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stat extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public int|string|null $number = null,

        public bool|string $tooltip = false,
        public bool|string $increase = false,
        public bool|string $decrease = false,

        // Stat types
        public bool $primary = false,
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
    ) {}

    public function statColorClasses(): string
    {
        return match (true) {
            $this->primary => 'border-primary/40',
            $this->secondary => 'border-secondary/40',
            $this->black => 'border-black-500/40',
            $this->white => 'border-white-500/40',
            $this->slate => 'border-slate-500/40',
            $this->gray => 'border-gray-500/40',
            $this->zinc => 'border-zinc-500/40',
            $this->neutral => 'border-neutral-500/40',
            $this->stone => 'border-stone-500/40',
            $this->red => 'border-red-500/40',
            $this->orange => 'border-orange-500/40',
            $this->amber => 'border-amber-500/40',
            $this->yellow => 'border-yellow-500/40',
            $this->lime => 'border-lime-500/40',
            $this->green => 'border-green-500/40',
            $this->emerald => 'border-emerald-500/40',
            $this->teal => 'border-teal-500/40',
            $this->cyan => 'border-cyan-500/40',
            $this->sky => 'border-sky-500/40',
            $this->blue => 'border-blue-500/40',
            $this->indigo => 'border-indigo-500/40',
            $this->violet => 'border-violet-500/40',
            $this->purple => 'border-purple-500/40',
            $this->fuchsia => 'border-fuchsia-500/40',
            $this->pink => 'border-pink-500/40',
            $this->rose => 'border-rose-500/40',
            default => 'border-gray-200 dark:border-gray-600',
        };
    }

    public function iconBgColor(): string
    {
        return match (true) {
            $this->primary => 'bg-primary/20 dark:bg-primary/50 dark:text-gray-200',
            $this->secondary => 'bg-secondary/20 dark:bg-secondary/50 dark:text-gray-200',
            $this->black => 'bg-black-500/20 dark:bg-black-500/50 dark:text-gray-200',
            $this->white => 'bg-white-500/20 dark:bg-white-500/50 dark:text-gray-200',
            $this->slate => 'bg-slate-500/20 dark:bg-slate-500/50 dark:text-gray-200',
            $this->gray => 'bg-gray-500/20 dark:bg-gray-500/50 dark:text-gray-200',
            $this->zinc => 'bg-zinc-500/20 dark:bg-zinc-500/50 dark:text-gray-200',
            $this->neutral => 'bg-neutral-500/20 dark:bg-neutral-500/50 dark:text-gray-200',
            $this->stone => 'bg-stone-500/20 dark:bg-stone-500/50 dark:text-gray-200',
            $this->red => 'bg-red-500/20 dark:bg-red-500/50 dark:text-gray-200',
            $this->orange => 'bg-orange-500/20 dark:bg-orange-500/50 dark:text-gray-200',
            $this->amber => 'bg-amber-500/20 dark:bg-amber-500/50 dark:text-gray-200',
            $this->yellow => 'bg-yellow-500/20 dark:bg-yellow-500/50 dark:text-gray-200',
            $this->lime => 'bg-lime-500/20 dark:bg-lime-500/50 dark:text-gray-200',
            $this->green => 'bg-green-500/20 dark:bg-green-500/50 dark:text-gray-200',
            $this->emerald => 'bg-emerald-500/20 dark:bg-emerald-500/50 dark:text-gray-200',
            $this->teal => 'bg-teal-500/20 dark:bg-teal-500/50 dark:text-gray-200',
            $this->cyan => 'bg-cyan-500/20 dark:bg-cyan-500/50 dark:text-gray-200',
            $this->sky => 'bg-sky-500/20 dark:bg-sky-500/50 dark:text-gray-200',
            $this->blue => 'bg-blue-500/20 dark:bg-blue-500/50 dark:text-gray-200',
            $this->indigo => 'bg-indigo-500/20 dark:bg-indigo-500/50 dark:text-gray-200',
            $this->violet => 'bg-violet-500/20 dark:bg-violet-500/50 dark:text-gray-200',
            $this->purple => 'bg-purple-500/20 dark:bg-purple-500/50 dark:text-gray-200',
            $this->fuchsia => 'bg-fuchsia-500/20 dark:bg-fuchsia-500/50 dark:text-gray-200',
            $this->pink => 'bg-pink-500/20 dark:bg-pink-500/50 dark:text-gray-200',
            $this->rose => 'bg-rose-500/20 dark:bg-rose-500/50 dark:text-gray-200',
            default => 'border-gray-200 dark:border-gray-600',
        };
    }

    public function iconRightClass()
    {
        return $this->iconRight != null ? 'order-2' : '';
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('stat', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->withoutTwMergeClasses()->twMerge([
                            "flex flex-col bg-white border shadow-sm dark:bg-gray-800",
                            $statColorClasses(),
                            $roundedClass(),
                        ]) 
                    }}
                >
                <div class="flex p-4 gap-x-4 md:p-5">
                    @if($icon || $iconRight)
                        <div {{ $attributes->twMergeFor(
                                'icon', 
                                "flex size-[46px] shrink-0 items-center text-gray-600 dark:text-gray-400 justify-center bg-gray-100 dark:bg-gray-700",
                                $iconBgColor(),
                                $iconRightClass(),
                                $roundedClass(),
                            ) 
                        }}>
                            <x-tc-icon :name="$icon ?? $iconRight" class="size-5 shrink-0" />
                        </div>
                    @endif

                    <div @class(["grow", "order-1" => $iconRight])>
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-gray-400">{{ __($title) }}</p>
                            
                            @if($tooltip)
                                <div title="{{ is_string($tooltip) ? $tooltip : $title }}">
                                    <x-tc-icon name="question-mark-circle" class="text-gray-500 size-[18px] shrink-0 dark:text-gray-400" />
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center mt-1 gap-x-2">
                            <h3 class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-gray-200">{{ __($number) }}</h3>
                            
                            @if($increase || $decrease)
                                <span @class([
                                        'inline-flex items-center gap-x-1 rounded-full px-2 py-0.5',
                                        'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' => $increase,
                                        'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' => $decrease,
                                    ])>
                                    <x-tc-icon :name="$decrease ? 'arrow-trending-down' : 'arrow-trending-up'" class="size-4" />
                                    
                                    @if(is_string($increase) || is_string($decrease))
                                        <span class="inline-block text-xs font-medium"> {{ is_string($increase) ? $increase : $decrease }} </span>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
