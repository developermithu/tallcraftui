<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasRadioColors
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
            $this->attributes->get('secondary') => 'text-secondary focus:ring-secondary',
            $this->attributes->get('black') => 'text-black focus:ring-black',
            $this->attributes->get('white') => 'text-white focus:ring-white border-gray-200',
            $this->attributes->get('slate') => 'text-slate-600 focus:ring-slate-500',
            $this->attributes->get('gray') => 'text-gray-600 focus:ring-gray-500',
            $this->attributes->get('zinc') => 'text-zinc-600 focus:ring-zinc-500',
            $this->attributes->get('neutral') => 'text-neutral-600 focus:ring-neutral-500',
            $this->attributes->get('stone') => 'text-stone-600 focus:ring-stone-500',
            $this->attributes->get('red') => 'text-red-600 focus:ring-red-500',
            $this->attributes->get('orange') => 'text-orange-600 focus:ring-orange-500',
            $this->attributes->get('amber') => 'text-amber-600 focus:ring-amber-500',
            $this->attributes->get('yellow') => 'text-yellow-600 focus:ring-yellow-500',
            $this->attributes->get('lime') => 'text-lime-600 focus:ring-lime-500',
            $this->attributes->get('green') => 'text-green-600 focus:ring-green-500',
            $this->attributes->get('emerald') => 'text-emerald-600 focus:ring-emerald-500',
            $this->attributes->get('teal') => 'text-teal-600 focus:ring-teal-500',
            $this->attributes->get('cyan') => 'text-cyan-600 focus:ring-cyan-500',
            $this->attributes->get('sky') => 'text-sky-600 focus:ring-sky-500',
            $this->attributes->get('blue') => 'text-blue-600 focus:ring-blue-500',
            $this->attributes->get('indigo') => 'text-indigo-600 focus:ring-indigo-500',
            $this->attributes->get('violet') => 'text-violet-600 focus:ring-violet-500',
            $this->attributes->get('purple') => 'text-purple-600 focus:ring-purple-500',
            $this->attributes->get('fuchsia') => 'text-fuchsia-600 focus:ring-fuchsia-500',
            $this->attributes->get('pink') => 'text-pink-600 focus:ring-pink-500',
            $this->attributes->get('rose') => 'text-rose-600 focus:ring-rose-500',
            default => 'text-primary focus:ring-primary', // primary
        };
    }
}
