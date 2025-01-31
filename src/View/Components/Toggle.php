<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?bool $textLeft = false,
        public bool $required = false,

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
        public ?bool $sm = false,
        public ?bool $md = false,
        public ?bool $lg = false,
    ) {}

    public function toggleColor(): string
    {
        return match (true) {
            $this->secondary => 'peer-focus:ring-secondary dark:peer-focus:ring-secondary peer-checked:bg-secondary',
            $this->black => 'peer-focus:ring-gray-900 dark:peer-focus:ring-gray-900 peer-checked:bg-gray-900',
            $this->white => 'peer-focus:ring-gray-50 dark:peer-focus:ring-gray-50 peer-checked:bg-gray-50 dark:peer-checked:bg-gray-300',
            $this->slate => 'peer-focus:ring-slate-500 dark:peer-focus:ring-slate-500 peer-checked:bg-slate-500',
            $this->gray => 'peer-focus:ring-gray-500 dark:peer-focus:ring-gray-500 peer-checked:bg-gray-500',
            $this->zinc => 'peer-focus:ring-zinc-500 dark:peer-focus:ring-zinc-500 peer-checked:bg-zinc-500',
            $this->neutral => 'peer-focus:ring-neutral-500 dark:peer-focus:ring-neutral-500 peer-checked:bg-neutral-500',
            $this->stone => 'peer-focus:ring-stone-500 dark:peer-focus:ring-stone-500 peer-checked:bg-stone-500',
            $this->red => 'peer-focus:ring-red-500 dark:peer-focus:ring-red-500 peer-checked:bg-red-500',
            $this->orange => 'peer-focus:ring-orange-500 dark:peer-focus:ring-orange-500 peer-checked:bg-orange-500',
            $this->amber => 'peer-focus:ring-amber-500 dark:peer-focus:ring-amber-500 peer-checked:bg-amber-500',
            $this->yellow => 'peer-focus:ring-yellow-500 dark:peer-focus:ring-yellow-500 peer-checked:bg-yellow-500',
            $this->lime => 'peer-focus:ring-lime-500 dark:peer-focus:ring-lime-500 peer-checked:bg-lime-500',
            $this->green => 'peer-focus:ring-green-500 dark:peer-focus:ring-green-500 peer-checked:bg-green-500',
            $this->emerald => 'peer-focus:ring-emerald-500 dark:peer-focus:ring-emerald-500 peer-checked:bg-emerald-500',
            $this->teal => 'peer-focus:ring-teal-500 dark:peer-focus:ring-teal-500 peer-checked:bg-teal-500',
            $this->cyan => 'peer-focus:ring-cyan-500 dark:peer-focus:ring-cyan-500 peer-checked:bg-cyan-500',
            $this->sky => 'peer-focus:ring-sky-500 dark:peer-focus:ring-sky-500 peer-checked:bg-sky-500',
            $this->blue => 'peer-focus:ring-blue-500 dark:peer-focus:ring-blue-500 peer-checked:bg-blue-500',
            $this->indigo => 'peer-focus:ring-indigo-500 dark:peer-focus:ring-indigo-500 peer-checked:bg-indigo-500',
            $this->violet => 'peer-focus:ring-violet-500 dark:peer-focus:ring-violet-500 peer-checked:bg-violet-500',
            $this->purple => 'peer-focus:ring-purple-500 dark:peer-focus:ring-purple-500 peer-checked:bg-purple-500',
            $this->fuchsia => 'peer-focus:ring-fuchsia-500 dark:peer-focus:ring-fuchsia-500 peer-checked:bg-fuchsia-500',
            $this->pink => 'peer-focus:ring-pink-500 dark:peer-focus:ring-pink-500 peer-checked:bg-pink-500',
            $this->rose => 'peer-focus:ring-rose-500 dark:peer-focus:ring-rose-500 peer-checked:bg-rose-500',
            default => 'peer-focus:ring-primary dark:peer-focus:ring-primary peer-checked:bg-primary', // primary
        };
    }

    public function sizes(): string
    {
        return match (true) {
            $this->sm => 'w-9 h-5 after:h-4 after:w-4 after:start-[2px]',
            $this->md => 'w-11 h-6 after:h-5 after:w-5 after:start-[2px]',
            $this->lg => 'w-14 h-7 after:h-6 after:w-6 after:start-[4px]',
            default => 'w-11 h-6 after:h-5 after:w-5 after:start-[2px]', // md
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
               
                // Remove extra space & make label lowercase
                $label = trim($label);

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
                
                $isRequired = $hasStar || $required;
            @endphp
            
            <label @class(["inline-flex items-center cursor-pointer gap-3"])>
                <input type="checkbox" class="sr-only peer" {{ $attributes }}>
                
                @if($textLeft)
                    @if($label)
                        <span {{ $attributes->twMergeFor('label', 'text-sm font-medium text-gray-700 dark:text-gray-100', $error ? 'text-red-500' : '') }}>
                            {{ __($labelWithoutStar) }}

                            @if ($isRequired)
                                <span class="text-red-500">*</span>
                            @endif
                        </span>
                    @endif
                @endif

                <div {{ $attributes
                    ->whereStartsWith('class')
                    ->except(['wire:model'])
                    ->withoutTwMergeClasses()
                    ->twMerge([
                        "relative bg-gray-200 rounded-full peer peer-focus:ring-2 ring-offset-2 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5  after:bg-white after:border-gray-300 after:border after:rounded-full after:transition-all dark:border-gray-600 duration-200",
                        $error ? 'bg-red-500' : '',
                        $toggleColor(),
                        $sizes(),
                    ]) 
                }}></div>
                
                @if(!$textLeft)
                    @if($label)
                        <span {{ $attributes->twMergeFor('label', 'text-sm font-medium text-gray-700 dark:text-gray-100', $error ? 'text-red-500' : '') }}
                        >
                            {{ __($labelWithoutStar) }}

                            @if ($isRequired)
                                <span class="text-red-500">*</span>
                            @endif
                        </span>
                    @endif
                @endif
            </label>
        HTML;
    }
}
