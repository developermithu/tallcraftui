<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasProgressColors
{
    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->has('secondary') => 'bg-secondary',
            $this->attributes->has('black') => 'bg-black',
            $this->attributes->has('white') => 'bg-white',
            $this->attributes->has('slate') => 'bg-slate-500',
            $this->attributes->has('gray') => 'bg-gray-500',
            $this->attributes->has('zinc') => 'bg-zinc-500',
            $this->attributes->has('neutral') => 'bg-neutral-500',
            $this->attributes->has('stone') => 'bg-stone-500',
            $this->attributes->has('red') => 'bg-red-500',
            $this->attributes->has('orange') => 'bg-orange-500',
            $this->attributes->has('amber') => 'bg-amber-500',
            $this->attributes->has('yellow') => 'bg-yellow-500',
            $this->attributes->has('lime') => 'bg-lime-500',
            $this->attributes->has('green') => 'bg-green-500',
            $this->attributes->has('emerald') => 'bg-emerald-500',
            $this->attributes->has('teal') => 'bg-teal-500',
            $this->attributes->has('cyan') => 'bg-cyan-500',
            $this->attributes->has('sky') => 'bg-sky-500',
            $this->attributes->has('blue') => 'bg-blue-500',
            $this->attributes->has('indigo') => 'bg-indigo-500',
            $this->attributes->has('violet') => 'bg-violet-500',
            $this->attributes->has('purple') => 'bg-purple-500',
            $this->attributes->has('fuchsia') => 'bg-fuchsia-500',
            $this->attributes->has('pink') => 'bg-pink-500',
            $this->attributes->has('rose') => 'bg-rose-500',
            default => 'bg-primary'
        };
    }
}
