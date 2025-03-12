<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasProgressColors
{
    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'bg-secondary',
            $this->attributes->get('black') => 'bg-black',
            $this->attributes->get('white') => 'bg-white',
            $this->attributes->get('slate') => 'bg-slate-500',
            $this->attributes->get('gray') => 'bg-gray-500',
            $this->attributes->get('zinc') => 'bg-zinc-500',
            $this->attributes->get('neutral') => 'bg-neutral-500',
            $this->attributes->get('stone') => 'bg-stone-500',
            $this->attributes->get('red') => 'bg-red-500',
            $this->attributes->get('orange') => 'bg-orange-500',
            $this->attributes->get('amber') => 'bg-amber-500',
            $this->attributes->get('yellow') => 'bg-yellow-500',
            $this->attributes->get('lime') => 'bg-lime-500',
            $this->attributes->get('green') => 'bg-green-500',
            $this->attributes->get('emerald') => 'bg-emerald-500',
            $this->attributes->get('teal') => 'bg-teal-500',
            $this->attributes->get('cyan') => 'bg-cyan-500',
            $this->attributes->get('sky') => 'bg-sky-500',
            $this->attributes->get('blue') => 'bg-blue-500',
            $this->attributes->get('indigo') => 'bg-indigo-500',
            $this->attributes->get('violet') => 'bg-violet-500',
            $this->attributes->get('purple') => 'bg-purple-500',
            $this->attributes->get('fuchsia') => 'bg-fuchsia-500',
            $this->attributes->get('pink') => 'bg-pink-500',
            $this->attributes->get('rose') => 'bg-rose-500',
            default => 'bg-primary'
        };
    }
}
