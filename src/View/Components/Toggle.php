<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toggle extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $textLeft = false,
        public bool $required = false,

        // Toggle colors
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
    ) {}

    public function colorClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-secondary/90 focus:ring-secondary/90',
            $this->tertiary => 'text-tertiary/90 focus:ring-tertiary/90',
            $this->warning => 'text-warning/90 focus:ring-warning/90',
            $this->success => 'text-success/90 focus:ring-success/90',
            $this->info => 'text-info/90 focus:ring-info/90',
            $this->danger => 'text-danger/90 focus:ring-danger/90',

            // Tailwind Colors
            $this->black => 'text-black focus:ring-black',
            $this->white => 'text-white focus:ring-white !border-gray-200',
            $this->slate => 'text-slate-600 focus:ring-slate-600',
            $this->gray => 'text-gray-600 focus:ring-gray-600',
            $this->zinc => 'text-zinc-600 focus:ring-zinc-600',
            $this->neutral => 'text-neutral-600 focus:ring-neutral-600',
            $this->stone => 'text-stone-600 focus:ring-stone-600',
            $this->red => 'text-red-600 focus:ring-red-600',
            $this->orange => 'text-orange-600 focus:ring-orange-600',
            $this->amber => 'text-amber-600 focus:ring-amber-600',
            $this->yellow => 'text-yellow-600 focus:ring-yellow-600',
            $this->lime => 'text-lime-600 focus:ring-lime-600',
            $this->green => 'text-green-600 focus:ring-green-600',
            $this->emerald => 'text-emerald-600 focus:ring-emerald-600',
            $this->teal => 'text-teal-600 focus:ring-teal-600',
            $this->cyan => 'text-cyan-600 focus:ring-cyan-600',
            $this->sky => 'text-sky-600 focus:ring-sky-600',
            $this->blue => 'text-blue-600 focus:ring-blue-600',
            $this->indigo => 'text-indigo-600 focus:ring-indigo-600',
            $this->violet => 'text-violet-600 focus:ring-violet-600',
            $this->purple => 'text-purple-600 focus:ring-purple-600',
            $this->fuchsia => 'text-fuchsia-600 focus:ring-fuchsia-600',
            $this->pink => 'text-pink-600 focus:ring-pink-600',
            $this->rose => 'text-rose-600 focus:ring-rose-600',
            default => 'text-primary/90 focus:ring-primary/90', // primary
        };
    }

    public function sizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'size-4',
            $this->attributes->get('lg') => 'size-6',
            $this->attributes->get('xl') => 'size-7',
            $this->attributes->get('2xl') => 'size-8',
            default => 'size-[18px]',
        };
    }

    public function roundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-none',
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
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
               
                // Remove extra space & make label lowercase
                $label = trim(Str::lower($label));

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
                
                $isRequired = $hasStar || $required;
            @endphp
                
            <div x-data="{ switchOn: false }" class="flex items-center space-x-2">
                <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn" {{ $attributes->whereDoesntStartWith('class') }}>

                <button 
                    x-ref="switchButton"
                    type="button" 
                    @click="switchOn = ! switchOn"
                    :class="switchOn ? '!bg-blue-600' : 'bg-neutral-200'" 
                    @class([
                        "relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10", 
                        "!bg-red-500" => $error,
                    ])
                    x-cloak>
                    <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'" class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                </button>

                <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')" 
                    :class="{ '!text-blue-600': switchOn, 'text-gray-700 dark:text-gray-100': ! switchOn }"
                    @class(["text-sm font-medium select-none", "!text-red-500" => $error])
                    x-cloak>
                        {{ Str::ucfirst(__($labelWithoutStar)) }}

                        @if ($isRequired)
                            <span class="text-red-500">*</span>
                        @endif
                </label>
            </div>
        HTML;
    }
}
