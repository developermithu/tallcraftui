<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasCheckboxColors
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

    public function colorClasses(): string
    {
        return match (true) {
            $this->attributes->has('secondary') => 'text-secondary/90 focus:ring-secondary/90',
            $this->attributes->has('black') => 'text-black focus:ring-black',
            $this->attributes->has('white') => 'text-white focus:ring-white !border-gray-200',
            $this->attributes->has('slate') => 'text-slate-600 focus:ring-slate-600',
            $this->attributes->has('gray') => 'text-gray-600 focus:ring-gray-600',
            $this->attributes->has('zinc') => 'text-zinc-600 focus:ring-zinc-600',
            $this->attributes->has('neutral') => 'text-neutral-600 focus:ring-neutral-600',
            $this->attributes->has('stone') => 'text-stone-600 focus:ring-stone-600',
            $this->attributes->has('red') => 'text-red-600 focus:ring-red-600',
            $this->attributes->has('orange') => 'text-orange-600 focus:ring-orange-600',
            $this->attributes->has('amber') => 'text-amber-600 focus:ring-amber-600',
            $this->attributes->has('yellow') => 'text-yellow-600 focus:ring-yellow-600',
            $this->attributes->has('lime') => 'text-lime-600 focus:ring-lime-600',
            $this->attributes->has('green') => 'text-green-600 focus:ring-green-600',
            $this->attributes->has('emerald') => 'text-emerald-600 focus:ring-emerald-600',
            $this->attributes->has('teal') => 'text-teal-600 focus:ring-teal-600',
            $this->attributes->has('cyan') => 'text-cyan-600 focus:ring-cyan-600',
            $this->attributes->has('sky') => 'text-sky-600 focus:ring-sky-600',
            $this->attributes->has('blue') => 'text-blue-600 focus:ring-blue-600',
            $this->attributes->has('indigo') => 'text-indigo-600 focus:ring-indigo-600',
            $this->attributes->has('violet') => 'text-violet-600 focus:ring-violet-600',
            $this->attributes->has('purple') => 'text-purple-600 focus:ring-purple-600',
            $this->attributes->has('fuchsia') => 'text-fuchsia-600 focus:ring-fuchsia-600',
            $this->attributes->has('pink') => 'text-pink-600 focus:ring-pink-600',
            $this->attributes->has('rose') => 'text-rose-600 focus:ring-rose-600',
            default => 'text-primary/90 focus:ring-primary/90', // primary
        };
    }
}
