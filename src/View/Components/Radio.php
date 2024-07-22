<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $textLeft = false,

        // Radio colors
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
    ) {
        $this->uuid = md5(serialize($this));
    }

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
            $this->cyan => 'text-cyan-600 focus:ring-cyan-600',
            $this->sky => 'text-sky-600 focus:ring-sky-600',
            $this->purple => 'text-purple-600 focus:ring-purple-600',
            $this->fuchsia => 'text-fuchsia-600 focus:ring-fuchsia-600',
            $this->pink => 'text-pink-600 focus:ring-pink-600',
            $this->rose => 'text-rose-600 focus:ring-rose-600',
            default => 'text-indigo-600 focus:ring-indigo-600', // primary
        };
    }

    public function sizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'size-4',
            $this->attributes->get('lg') => 'size-6',
            $this->attributes->get('xl') => 'size-7',
            $this->attributes->get('xxl') => 'size-8',
            default => 'size-[18px]',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                $uuid = $uuid . $name;
                $required = $attributes->get('required') ? true : false;
            @endphp
                
            <div class="relative flex gap-x-3">
                @if($textLeft)
                    <div class="leading-6">
                        @if($label)
                            <x-tall-label :for="$uuid" :label="$label" :required="$required" radio />
                        @endif
                        
                        @if($hint)
                            <x-tall-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                @endif

                <div class="flex items-center h-6">
                    <input id="{{ $uuid }}" type="radio"
                        {{ $attributes
                            ->class([
                                "border-gray-300",
                                $sizeClasses(), 
                                $colorClasses(),       
                                "!border-red-300" => $error,                                
                                "!text-gray-300 pointer-events-none" => $attributes->get('disabled') || $attributes->get('readonly'),                             
                            ])
                        }}
                    />
                </div>

                <!-- Default -->
                @if(!$textLeft)
                    <div class="leading-6">
                        @if($label)
                            <x-tall-label :for="$uuid" :label="$label" :required="$required" radio />
                        @endif
                        
                        @if($hint)
                            <x-tall-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-0.5 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                @endif
            </div>
        HTML;
    }
}
