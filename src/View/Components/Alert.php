<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
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
        public bool $cyan = false,
        public bool $sky = false,
        public bool $purple = false,
        public bool $fuchsia = false,
        public bool $pink = false,
        public bool $rose = false,

        public bool $dismissible = false,
        public ?array $errors = null,
    ) {
    }

    public function alertIcon(): string
    {
        return $this->icon ?: match (true) {
            $this->warning => 'exclamation-triangle',
            $this->info || $this->secondary => 'information-circle',
            $this->danger => 'x-circle',
            default => 'check-circle',
        };
    }

    public function alertClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary border-secondary/20 bg-secondary/10 dark:bg-secondary/15 dark:border-secondary/50 dark:text-secondary',
            $this->tertiary => 'text-tertiary border-tertiary/20 bg-tertiary/10 dark:bg-tertiary/15 dark:border-tertiary/50 dark:text-tertiary',
            $this->warning => 'text-warning border-warning/20 bg-warning/10 dark:bg-warning/15 dark:border-warning/50 dark:text-warning',
            $this->info => 'text-info border-info/20 bg-info/10 dark:bg-info/15 dark:border-info/50 dark:text-info',
            $this->danger => 'text-danger border-danger/20 bg-danger/10 dark:bg-danger/15 dark:border-danger/50 dark:text-danger',
            $this->success => 'text-success border-success/20 bg-success/10 dark:bg-success/15 dark:border-success/50 dark:text-success',

            // Tailwind Colors 
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
            $this->cyan => 'text-cyan-800 border-cyan-200 bg-cyan-50 dark:bg-cyan-800/20 dark:border-cyan-900 dark:text-cyan-500',
            $this->sky => 'text-sky-800 border-sky-200 bg-sky-50 dark:bg-sky-800/20 dark:border-sky-900 dark:text-sky-500',
            $this->purple => 'text-purple-800 border-purple-200 bg-purple-50 dark:bg-purple-800/20 dark:border-purple-900 dark:text-purple-500',
            $this->fuchsia => 'text-fuchsia-800 border-fuchsia-200 bg-fuchsia-50 dark:bg-fuchsia-800/20 dark:border-fuchsia-900 dark:text-fuchsia-500',
            $this->pink => 'text-pink-800 border-pink-200 bg-pink-50 dark:bg-pink-800/20 dark:border-pink-900 dark:text-pink-500',
            $this->rose => 'text-rose-800 border-rose-200 bg-rose-50 dark:bg-rose-800/20 dark:border-rose-900 dark:text-rose-500',
            default => 'text-primary border-primary/20 bg-primary/10 dark:bg-primary/20 dark:border-primary dark:text-primary/80', // primary
        };
    }

    public function descriptionClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary/80 dark:text-secondary/80',
            $this->tertiary => 'text-tertiary/80 dark:text-tertiary/80',
            $this->warning => 'text-warning/80 dark:text-warning/80',
            $this->info => 'text-info/80 dark:text-info/80',
            $this->danger => 'text-danger/80 dark:text-danger/80',
            $this->success => 'text-success/80 dark:text-success/80',

            // Tailwind Colors 
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
            $this->cyan => 'text-cyan-700 dark:text-cyan-400',
            $this->sky => 'text-sky-700 dark:text-sky-400',
            $this->purple => 'text-purple-700 dark:text-purple-400',
            $this->fuchsia => 'text-fuchsia-700 dark:text-fuchsia-400',
            $this->pink => 'text-pink-700 dark:text-pink-400',
            $this->rose => 'text-rose-700 dark:text-rose-400',
            default => 'text-primary/80 dark:text-primary/80',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div 
                x-data="{ visible: true }"
                x-show="visible"
                x-cloak
                x-transition.duration.500ms.opacity
                @class(["p-4 text-sm transition duration-300 border rounded-lg", $alertClasses()])>
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <x-icon :name="$alertIcon()" class="{{ $errors ? '!text-danger/80': '' }}" />
                    </div>

                    <div @class(["ms-2","ms-4" => $description])>
                        <h3 class="text-sm font-medium">
                            {{ $title ?? $errors ? 'Something wents wrong!' : 'Alert title goes here' }}
                        </h3>
                        
                        @if($description)
                            <div @class(["mt-1 text-sm", $descriptionClasses()])>
                                {{ $description }}
                            </div>
                        @endif
                        
                        @if($errors)
                            <ul @class(["mt-2 text-sm list-disc space-y-1 ps-5", $descriptionClasses()])>
                                @foreach($errors as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                        @if($dismissible && !$actions)
                                @if($secondary) <x-button @click="visible = false" icon="x-mark" flat circle sm secondary /> @endif
                                @if($warning) <x-button @click="visible = false" icon="x-mark" flat circle sm warning /> @endif
                                @if($info) <x-button @click="visible = false" icon="x-mark" flat circle sm info /> @endif
                                @if($danger) <x-button @click="visible = false" icon="x-mark" flat circle sm danger /> @endif
                                @if($success) <x-button @click="visible = false" icon="x-mark" flat circle sm success /> @endif
                                @if(!$secondary && !$warning && !$info && !$danger && !$success ) 
                                    <x-button @click="visible = false" icon="x-mark" flat circle sm danger /> 
                                @endif
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
