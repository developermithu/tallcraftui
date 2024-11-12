<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Range extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?int $min = 0,
        public ?int $max = 100,
        public ?int $step = 1,

        public bool $black = false,
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
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function rangeColor(): string
    {
        return match (true) {
            $this->black => '[&::-webkit-slider-thumb]:bg-gray-50 [&::-moz-range-thumb]:bg-gray-50 [&::-ms-thumb]:bg-gray-50 dark:[&::-webkit-slider-thumb]:bg-gray-300 dark:[&::-moz-range-thumb]:bg-gray-300 dark:[&::-ms-thumb]:bg-gray-300 [&::-moz-range-progress]:bg-gray-400 [&::-ms-fill-lower]:bg-gray-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#000000]',

            $this->slate => '[&::-webkit-slider-thumb]:bg-slate-600 [&::-moz-range-thumb]:bg-slate-600 [&::-ms-thumb]:bg-slate-600 [&::-moz-range-progress]:bg-slate-400 [&::-ms-fill-lower]:bg-slate-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#94A3B8]',
            $this->gray => '[&::-webkit-slider-thumb]:bg-gray-600 [&::-moz-range-thumb]:bg-gray-600 [&::-ms-thumb]:bg-gray-600 [&::-moz-range-progress]:bg-gray-400 [&::-ms-fill-lower]:bg-gray-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#9CA3AF]',
            $this->zinc => '[&::-webkit-slider-thumb]:bg-zinc-600 [&::-moz-range-thumb]:bg-zinc-600 [&::-ms-thumb]:bg-zinc-600 [&::-moz-range-progress]:bg-zinc-400 [&::-ms-fill-lower]:bg-zinc-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A1A1AA]',
            $this->neutral => '[&::-webkit-slider-thumb]:bg-neutral-600 [&::-moz-range-thumb]:bg-neutral-600 [&::-ms-thumb]:bg-neutral-600 [&::-moz-range-progress]:bg-neutral-400 [&::-ms-fill-lower]:bg-neutral-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A3A3A3]',
            $this->stone => '[&::-webkit-slider-thumb]:bg-stone-600 [&::-moz-range-thumb]:bg-stone-600 [&::-ms-thumb]:bg-stone-600 [&::-moz-range-progress]:bg-stone-400 [&::-ms-fill-lower]:bg-stone-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A8A29E]',
            $this->red => '[&::-webkit-slider-thumb]:bg-red-600 [&::-moz-range-thumb]:bg-red-600 [&::-ms-thumb]:bg-red-600 [&::-moz-range-progress]:bg-red-400 [&::-ms-fill-lower]:bg-red-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#F87171]',
            $this->orange => '[&::-webkit-slider-thumb]:bg-orange-600 [&::-moz-range-thumb]:bg-orange-600 [&::-ms-thumb]:bg-orange-600 [&::-moz-range-progress]:bg-orange-400 [&::-ms-fill-lower]:bg-orange-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FB923C]',
            $this->amber => '[&::-webkit-slider-thumb]:bg-amber-600 [&::-moz-range-thumb]:bg-amber-600 [&::-ms-thumb]:bg-amber-600 [&::-moz-range-progress]:bg-amber-400 [&::-ms-fill-lower]:bg-amber-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FBBF24]',
            $this->yellow => '[&::-webkit-slider-thumb]:bg-yellow-600 [&::-moz-range-thumb]:bg-yellow-600 [&::-ms-thumb]:bg-yellow-600 [&::-moz-range-progress]:bg-yellow-400 [&::-ms-fill-lower]:bg-yellow-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FACC15]',
            $this->lime => '[&::-webkit-slider-thumb]:bg-lime-600 [&::-moz-range-thumb]:bg-lime-600 [&::-ms-thumb]:bg-lime-600 [&::-moz-range-progress]:bg-lime-400 [&::-ms-fill-lower]:bg-lime-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A3E635]',
            $this->green => '[&::-webkit-slider-thumb]:bg-green-600 [&::-moz-range-thumb]:bg-green-600 [&::-ms-thumb]:bg-green-600 [&::-moz-range-progress]:bg-green-400 [&::-ms-fill-lower]:bg-green-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#4ADE80]',
            $this->emerald => '[&::-webkit-slider-thumb]:bg-emerald-600 [&::-moz-range-thumb]:bg-emerald-600 [&::-ms-thumb]:bg-emerald-600 [&::-moz-range-progress]:bg-emerald-400 [&::-ms-fill-lower]:bg-emerald-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#34D399]',
            $this->teal => '[&::-webkit-slider-thumb]:bg-teal-600 [&::-moz-range-thumb]:bg-teal-600 [&::-ms-thumb]:bg-teal-600 [&::-moz-range-progress]:bg-teal-400 [&::-ms-fill-lower]:bg-teal-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#2DD4BF]',
            $this->cyan => '[&::-webkit-slider-thumb]:bg-cyan-600 [&::-moz-range-thumb]:bg-cyan-600 [&::-ms-thumb]:bg-cyan-600 [&::-moz-range-progress]:bg-cyan-400 [&::-ms-fill-lower]:bg-cyan-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#22D3EE]',
            $this->sky => '[&::-webkit-slider-thumb]:bg-sky-600 [&::-moz-range-thumb]:bg-sky-600 [&::-ms-thumb]:bg-sky-600 [&::-moz-range-progress]:bg-sky-400 [&::-ms-fill-lower]:bg-sky-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#38BDF8]',
            $this->blue => '[&::-webkit-slider-thumb]:bg-blue-600 [&::-moz-range-thumb]:bg-blue-600 [&::-ms-thumb]:bg-blue-600 [&::-moz-range-progress]:bg-blue-400 [&::-ms-fill-lower]:bg-blue-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#60A5FA]',
            $this->indigo => '[&::-webkit-slider-thumb]:bg-indigo-600 [&::-moz-range-thumb]:bg-indigo-600 [&::-ms-thumb]:bg-indigo-600 [&::-moz-range-progress]:bg-indigo-400 [&::-ms-fill-lower]:bg-indigo-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#818CF8]',
            $this->violet => '[&::-webkit-slider-thumb]:bg-violet-600 [&::-moz-range-thumb]:bg-violet-600 [&::-ms-thumb]:bg-violet-600 [&::-moz-range-progress]:bg-violet-400 [&::-ms-fill-lower]:bg-violet-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A78BFA]',
            $this->purple => '[&::-webkit-slider-thumb]:bg-purple-600 [&::-moz-range-thumb]:bg-purple-600 [&::-ms-thumb]:bg-purple-600 [&::-moz-range-progress]:bg-purple-400 [&::-ms-fill-lower]:bg-purple-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#C084FC]',
            $this->fuchsia => '[&::-webkit-slider-thumb]:bg-fuchsia-600 [&::-moz-range-thumb]:bg-fuchsia-600 [&::-ms-thumb]:bg-fuchsia-600 [&::-moz-range-progress]:bg-fuchsia-400 [&::-ms-fill-lower]:bg-fuchsia-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#E879F9]',
            $this->pink => '[&::-webkit-slider-thumb]:bg-pink-600 [&::-moz-range-thumb]:bg-pink-600 [&::-ms-thumb]:bg-pink-600 [&::-moz-range-progress]:bg-pink-400 [&::-ms-fill-lower]:bg-pink-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#F472B6]',
            $this->rose => '[&::-webkit-slider-thumb]:bg-rose-600 [&::-moz-range-thumb]:bg-rose-600 [&::-ms-thumb]:bg-rose-600 [&::-moz-range-progress]:bg-rose-400 [&::-ms-fill-lower]:bg-rose-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FB7185]',

            default => '[&::-webkit-slider-thumb]:bg-blue-600 [&::-moz-range-thumb]:bg-blue-600 [&::-ms-thumb]:bg-blue-600 [&::-moz-range-progress]:bg-blue-400 [&::-ms-fill-lower]:bg-blue-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#60A5FA]',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div @class(['inline-flex w-full items-center gap-3' => $inline])>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" 
                        {{ $attributes->twMergeFor('label', !$inline ? 'mb-3' : '') }}
                    />
                @endif

                <div class="relative flex items-center flex-1">
                    <input
                        type="range"
                        id="{{ $uuid }}"
                        min="{{ $min }}"
                        max="{{ $max }}"
                        step="{{ $step }}"
                        {{ 
                            $attributes
                                ->withoutTwMergeClasses()
                                ->twMerge([
                                    "block w-full h-2 appearance-none cursor-pointer bg-transparent z-30",
                                    "[&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-0 [&::-moz-range-thumb]:w-5 [&::-moz-range-thumb]:h-5 [&::-moz-range-thumb]:appearance-none [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-0 [&::-ms-thumb]:w-5 [&::-ms-thumb]:h-5 [&::-ms-thumb]:appearance-none [&::-ms-thumb]:rounded-full [&::-ms-thumb]:border-0 [&::-webkit-slider-runnable-track]:rounded-full [&::-webkit-slider-runnable-track]:overflow-hidden [&::-moz-range-track]:rounded-full [&::-ms-track]:rounded-full [&::-moz-range-progress]:rounded-full [&::-ms-fill-lower]:rounded-full [&::-webkit-slider-runnable-track]:bg-gray-200 [&::-moz-range-track]:bg-gray-200 [&::-ms-track]:bg-gray-200 dark:[&::-webkit-slider-runnable-track]:bg-gray-800 dark:[&::-moz-range-track]:bg-gray-800 dark:[&::-ms-track]:bg-gray-800",
                                    $rangeColor(),
                                ])
                        }}
                    />
                </div>

                @if($hint && !$error)
                    <x-tc-hint :hint="$hint" @class(["mt-2.5" => !$inline]) />
                @endif
                
                @if($error)
                    <p @class(["text-sm text-red-500", "mt-2.5" => !$inline])>{{ $error }}</p>
                @endif
            </div>
        HTML;
    }
}
