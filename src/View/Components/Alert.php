<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $actions = null,

        // Alert types
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

        public bool $dismissible = false,
        public ?array $errors = null,
    ) {}

    public function alertIcon(): string
    {
        return $this->icon ?: match (true) {
            $this->yellow || $this->orange || $this->amber => 'exclamation-triangle',
            $this->blue || $this->secondary => 'information-circle',
            $this->red => 'x-circle',
            default => 'check-circle',
        };
    }

    public function alertClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary border-secondary/20 bg-secondary/10 dark:bg-secondary/15 dark:border-secondary/50 dark:text-secondary',
            $this->black => 'text-black-800 border-black-200 bg-black-50 dark:bg-black-800/20 dark:border-black-900 dark:text-black-500',
            $this->white => 'text-white-800 border-white-200 bg-white-50 dark:bg-white-800/20 dark:border-white-900 dark:text-white-500',
            $this->slate => 'text-slate-800 border-slate-200 bg-slate-50 dark:bg-slate-800/20 dark:border-slate-900 dark:text-slate-500',
            $this->gray => 'text-gray-800 border-gray-200 bg-gray-50 dark:bg-gray-800/20 dark:border-gray-900 dark:text-gray-500',
            $this->zinc => 'text-zinc-800 border-zinc-200 bg-zinc-50 dark:bg-zinc-800/20 dark:border-zinc-900 dark:text-zinc-500',
            $this->neutral => 'text-neutral-800 border-neutral-200 bg-neutral-50 dark:bg-neutral-800/20 dark:border-neutral-900 dark:text-neutral-500',
            $this->stone => 'text-stone-800 border-stone-200 bg-stone-50 dark:bg-stone-800/20 dark:border-stone-900 dark:text-stone-500',
            $this->red => 'text-red-800 border-red-200 bg-red-50 dark:bg-red-800/20 dark:border-red-900 dark:text-red-500',
            $this->orange => 'text-orange-800 border-orange-200 bg-orange-50 dark:bg-orange-800/20 dark:border-orange-900 dark:text-orange-500',
            $this->amber => 'text-amber-800 border-amber-200 bg-amber-50 dark:bg-amber-800/20 dark:border-amber-900 dark:text-amber-500',
            $this->yellow => 'text-yellow-800 border-yellow-200 bg-yellow-50 dark:bg-yellow-800/20 dark:border-yellow-900 dark:text-yellow-500',
            $this->lime => 'text-lime-800 border-lime-200 bg-lime-50 dark:bg-lime-800/20 dark:border-lime-900 dark:text-lime-500',
            $this->green => 'text-green-800 border-green-200 bg-green-50 dark:bg-green-800/20 dark:border-green-900 dark:text-green-500',
            $this->emerald => 'text-emerald-800 border-emerald-200 bg-emerald-50 dark:bg-emerald-800/20 dark:border-emerald-900 dark:text-emerald-500',
            $this->teal => 'text-teal-800 border-teal-200 bg-teal-50 dark:bg-teal-800/20 dark:border-teal-900 dark:text-teal-500',
            $this->cyan => 'text-cyan-800 border-cyan-200 bg-cyan-50 dark:bg-cyan-800/20 dark:border-cyan-900 dark:text-cyan-500',
            $this->sky => 'text-sky-800 border-sky-200 bg-sky-50 dark:bg-sky-800/20 dark:border-sky-900 dark:text-sky-500',
            $this->blue => 'text-blue-800 border-blue-200 bg-blue-50 dark:bg-blue-800/20 dark:border-blue-900 dark:text-blue-500',
            $this->indigo => 'text-indigo-800 border-indigo-200 bg-indigo-50 dark:bg-indigo-800/20 dark:border-indigo-900 dark:text-indigo-500',
            $this->violet => 'text-violet-800 border-violet-200 bg-violet-50 dark:bg-violet-800/20 dark:border-violet-900 dark:text-violet-500',
            $this->purple => 'text-purple-800 border-purple-200 bg-purple-50 dark:bg-purple-800/20 dark:border-purple-900 dark:text-purple-500',
            $this->fuchsia => 'text-fuchsia-800 border-fuchsia-200 bg-fuchsia-50 dark:bg-fuchsia-800/20 dark:border-fuchsia-900 dark:text-fuchsia-500',
            $this->pink => 'text-pink-800 border-pink-200 bg-pink-50 dark:bg-pink-800/20 dark:border-pink-900 dark:text-pink-500',
            $this->rose => 'text-rose-800 border-rose-200 bg-rose-50 dark:bg-rose-800/20 dark:border-rose-900 dark:text-rose-500',
            default => 'text-primary border-primary/20 bg-primary/10 dark:bg-primary/20 dark:border-primary dark:text-primary/80', // primary
        };
    }

    public function textColor(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary dark:text-secondary',
            $this->black => 'text-black-700 dark:text-black-400',
            $this->white => 'text-white-700 dark:text-white-400',
            $this->slate => 'text-slate-700 dark:text-slate-400',
            $this->gray => 'text-gray-700 dark:text-gray-400',
            $this->zinc => 'text-zinc-700 dark:text-zinc-400',
            $this->neutral => 'text-neutral-700 dark:text-neutral-400',
            $this->stone => 'text-stone-700 dark:text-stone-400',
            $this->red => 'text-red-700 dark:text-red-400',
            $this->orange => 'text-orange-700 dark:text-orange-400',
            $this->amber => 'text-amber-700 dark:text-amber-400',
            $this->yellow => 'text-yellow-700 dark:text-yellow-400',
            $this->lime => 'text-lime-700 dark:text-lime-400',
            $this->green => 'text-green-700 dark:text-green-400',
            $this->emerald => 'text-emerald-700 dark:text-emerald-400',
            $this->teal => 'text-teal-700 dark:text-teal-400',
            $this->cyan => 'text-cyan-700 dark:text-cyan-400',
            $this->sky => 'text-sky-700 dark:text-sky-400',
            $this->blue => 'text-blue-700 dark:text-blue-400',
            $this->indigo => 'text-indigo-700 dark:text-indigo-400',
            $this->violet => 'text-violet-700 dark:text-violet-400',
            $this->purple => 'text-purple-700 dark:text-purple-400',
            $this->fuchsia => 'text-fuchsia-700 dark:text-fuchsia-400',
            $this->pink => 'text-pink-700 dark:text-pink-400',
            $this->rose => 'text-rose-700 dark:text-rose-400',
            default => 'text-primary dark:text-primary', // primary
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('alert', $this->attributes);
    }

    public function actionColors(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->black => 'text-black-600 hover:bg-black-500/10 focus:bg-black-500/15 focus:ring-black-500',
            $this->white => 'text-white-600 hover:bg-white-500/10 focus:bg-white-500/15 focus:ring-white-500',
            $this->slate => 'text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->gray => 'text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->zinc => 'text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->neutral => 'text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->stone => 'text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->red => 'text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->orange => 'text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->amber => 'text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->yellow => 'text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->lime => 'text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->green => 'text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->emerald => 'text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->teal => 'text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->cyan => 'text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->sky => 'text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->blue => 'text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->indigo => 'text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->violet => 'text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->purple => 'text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->fuchsia => 'text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->pink => 'text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->rose => 'text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => 'text-primary hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70', // primary
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $alertTitle = $title ?? ($errors ? 'Something went wrong!' : 'Alert title goes here');
            @endphp
            
            <div 
                x-data="{ visible: true }"
                x-show="visible"
                x-cloak
                x-transition.duration.500ms.opacity
                    {{ $attributes->withoutTwMergeClasses()->twMerge([
                            "p-3 text-sm transition duration-300 border", 
                            $alertClasses(), 
                            $roundedClass()
                        ]) 
                    }}
                >
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <x-tc-icon :name="$alertIcon()" class="size-5 opacity-80 {{ $errors ? 'text-red-500': '' }}" />
                    </div>

                    <div @class(["ms-2","sm:ms-4" => $description])>
                        <h3 @class(["text-sm font-medium", $textColor()])>
                            {{ $alertTitle }}
                        </h3>
                        
                        @if($description)
                            <div @class(["mt-1 text-sm opacity-90", $textColor()])>
                                {{ $description }}
                            </div>
                        @endif
                        
                        @if($errors)
                            <ul @class(["mt-2 text-sm list-disc space-y-1 ps-5", $textColor()])>
                                @foreach($errors as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                            @if($dismissible && !$actions)
                                <button @click="visible = false"
                                        {{ $attributes->twMergeFor(
                                                "action",
                                                "flex items-center justify-center transition duration-200 ease-in-out bg-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-0 size-8",
                                                $actionColors(),
                                            )
                                        }}
                                    >
                                        <x-tc-icon name="x-mark" />
                                </button>
                            @else 
                                {{ $actions }}    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
