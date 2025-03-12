<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasRangeColors
{
    public array $colorAttributes = [
        'primary',
        'secondary',
        'black',
        'white',
        'slate',
        'gray',
        'zinc',
        'neutral',
        'stone',
        'red',
        'orange',
        'amber',
        'yellow',
        'lime',
        'green',
        'emerald',
        'teal',
        'cyan',
        'sky',
        'blue',
        'indigo',
        'violet',
        'purple',
        'fuchsia',
        'pink',
        'rose',
    ];

    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('black') => '[&::-webkit-slider-thumb]:bg-gray-50 [&::-moz-range-thumb]:bg-gray-50 [&::-ms-thumb]:bg-gray-50 dark:[&::-webkit-slider-thumb]:bg-gray-300 dark:[&::-moz-range-thumb]:bg-gray-300 dark:[&::-ms-thumb]:bg-gray-300 [&::-moz-range-progress]:bg-gray-400 [&::-ms-fill-lower]:bg-gray-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#000000]',

            $this->attributes->get('slate') => '[&::-webkit-slider-thumb]:bg-slate-600 [&::-moz-range-thumb]:bg-slate-600 [&::-ms-thumb]:bg-slate-600 [&::-moz-range-progress]:bg-slate-400 [&::-ms-fill-lower]:bg-slate-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#94A3B8]',
            $this->attributes->get('gray') => '[&::-webkit-slider-thumb]:bg-gray-600 [&::-moz-range-thumb]:bg-gray-600 [&::-ms-thumb]:bg-gray-600 [&::-moz-range-progress]:bg-gray-400 [&::-ms-fill-lower]:bg-gray-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#9CA3AF]',
            $this->attributes->get('zinc') => '[&::-webkit-slider-thumb]:bg-zinc-600 [&::-moz-range-thumb]:bg-zinc-600 [&::-ms-thumb]:bg-zinc-600 [&::-moz-range-progress]:bg-zinc-400 [&::-ms-fill-lower]:bg-zinc-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A1A1AA]',
            $this->attributes->get('neutral') => '[&::-webkit-slider-thumb]:bg-neutral-600 [&::-moz-range-thumb]:bg-neutral-600 [&::-ms-thumb]:bg-neutral-600 [&::-moz-range-progress]:bg-neutral-400 [&::-ms-fill-lower]:bg-neutral-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A3A3A3]',
            $this->attributes->get('stone') => '[&::-webkit-slider-thumb]:bg-stone-600 [&::-moz-range-thumb]:bg-stone-600 [&::-ms-thumb]:bg-stone-600 [&::-moz-range-progress]:bg-stone-400 [&::-ms-fill-lower]:bg-stone-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A8A29E]',
            $this->attributes->get('red') => '[&::-webkit-slider-thumb]:bg-red-600 [&::-moz-range-thumb]:bg-red-600 [&::-ms-thumb]:bg-red-600 [&::-moz-range-progress]:bg-red-400 [&::-ms-fill-lower]:bg-red-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#F87171]',
            $this->attributes->get('orange') => '[&::-webkit-slider-thumb]:bg-orange-600 [&::-moz-range-thumb]:bg-orange-600 [&::-ms-thumb]:bg-orange-600 [&::-moz-range-progress]:bg-orange-400 [&::-ms-fill-lower]:bg-orange-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FB923C]',
            $this->attributes->get('amber') => '[&::-webkit-slider-thumb]:bg-amber-600 [&::-moz-range-thumb]:bg-amber-600 [&::-ms-thumb]:bg-amber-600 [&::-moz-range-progress]:bg-amber-400 [&::-ms-fill-lower]:bg-amber-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FBBF24]',
            $this->attributes->get('yellow') => '[&::-webkit-slider-thumb]:bg-yellow-600 [&::-moz-range-thumb]:bg-yellow-600 [&::-ms-thumb]:bg-yellow-600 [&::-moz-range-progress]:bg-yellow-400 [&::-ms-fill-lower]:bg-yellow-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FACC15]',
            $this->attributes->get('lime') => '[&::-webkit-slider-thumb]:bg-lime-600 [&::-moz-range-thumb]:bg-lime-600 [&::-ms-thumb]:bg-lime-600 [&::-moz-range-progress]:bg-lime-400 [&::-ms-fill-lower]:bg-lime-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A3E635]',
            $this->attributes->get('green') => '[&::-webkit-slider-thumb]:bg-green-600 [&::-moz-range-thumb]:bg-green-600 [&::-ms-thumb]:bg-green-600 [&::-moz-range-progress]:bg-green-400 [&::-ms-fill-lower]:bg-green-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#4ADE80]',
            $this->attributes->get('emerald') => '[&::-webkit-slider-thumb]:bg-emerald-600 [&::-moz-range-thumb]:bg-emerald-600 [&::-ms-thumb]:bg-emerald-600 [&::-moz-range-progress]:bg-emerald-400 [&::-ms-fill-lower]:bg-emerald-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#34D399]',
            $this->attributes->get('teal') => '[&::-webkit-slider-thumb]:bg-teal-600 [&::-moz-range-thumb]:bg-teal-600 [&::-ms-thumb]:bg-teal-600 [&::-moz-range-progress]:bg-teal-400 [&::-ms-fill-lower]:bg-teal-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#2DD4BF]',
            $this->attributes->get('cyan') => '[&::-webkit-slider-thumb]:bg-cyan-600 [&::-moz-range-thumb]:bg-cyan-600 [&::-ms-thumb]:bg-cyan-600 [&::-moz-range-progress]:bg-cyan-400 [&::-ms-fill-lower]:bg-cyan-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#22D3EE]',
            $this->attributes->get('sky') => '[&::-webkit-slider-thumb]:bg-sky-600 [&::-moz-range-thumb]:bg-sky-600 [&::-ms-thumb]:bg-sky-600 [&::-moz-range-progress]:bg-sky-400 [&::-ms-fill-lower]:bg-sky-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#38BDF8]',
            $this->attributes->get('blue') => '[&::-webkit-slider-thumb]:bg-blue-600 [&::-moz-range-thumb]:bg-blue-600 [&::-ms-thumb]:bg-blue-600 [&::-moz-range-progress]:bg-blue-400 [&::-ms-fill-lower]:bg-blue-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#60A5FA]',
            $this->attributes->get('indigo') => '[&::-webkit-slider-thumb]:bg-indigo-600 [&::-moz-range-thumb]:bg-indigo-600 [&::-ms-thumb]:bg-indigo-600 [&::-moz-range-progress]:bg-indigo-400 [&::-ms-fill-lower]:bg-indigo-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#818CF8]',
            $this->attributes->get('violet') => '[&::-webkit-slider-thumb]:bg-violet-600 [&::-moz-range-thumb]:bg-violet-600 [&::-ms-thumb]:bg-violet-600 [&::-moz-range-progress]:bg-violet-400 [&::-ms-fill-lower]:bg-violet-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#A78BFA]',
            $this->attributes->get('purple') => '[&::-webkit-slider-thumb]:bg-purple-600 [&::-moz-range-thumb]:bg-purple-600 [&::-ms-thumb]:bg-purple-600 [&::-moz-range-progress]:bg-purple-400 [&::-ms-fill-lower]:bg-purple-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#C084FC]',
            $this->attributes->get('fuchsia') => '[&::-webkit-slider-thumb]:bg-fuchsia-600 [&::-moz-range-thumb]:bg-fuchsia-600 [&::-ms-thumb]:bg-fuchsia-600 [&::-moz-range-progress]:bg-fuchsia-400 [&::-ms-fill-lower]:bg-fuchsia-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#E879F9]',
            $this->attributes->get('pink') => '[&::-webkit-slider-thumb]:bg-pink-600 [&::-moz-range-thumb]:bg-pink-600 [&::-ms-thumb]:bg-pink-600 [&::-moz-range-progress]:bg-pink-400 [&::-ms-fill-lower]:bg-pink-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#F472B6]',
            $this->attributes->get('rose') => '[&::-webkit-slider-thumb]:bg-rose-600 [&::-moz-range-thumb]:bg-rose-600 [&::-ms-thumb]:bg-rose-600 [&::-moz-range-progress]:bg-rose-400 [&::-ms-fill-lower]:bg-rose-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#FB7185]',

            default => '[&::-webkit-slider-thumb]:bg-blue-600 [&::-moz-range-thumb]:bg-blue-600 [&::-ms-thumb]:bg-blue-600 [&::-moz-range-progress]:bg-blue-400 [&::-ms-fill-lower]:bg-blue-400 [&::-webkit-slider-thumb]:shadow-[-999px_0px_0px_990px_#60A5FA]',
        };
    }
}