<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasProgressRadialColors
{
    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'stroke-secondary',
            $this->attributes->get('black') => 'stroke-black',
            $this->attributes->get('white') => 'stroke-white',
            $this->attributes->get('slate') => 'stroke-slate-500',
            $this->attributes->get('gray') => 'stroke-gray-500',
            $this->attributes->get('zinc') => 'stroke-zinc-500',
            $this->attributes->get('neutral') => 'stroke-neutral-500',
            $this->attributes->get('stone') => 'stroke-stone-500',
            $this->attributes->get('red') => 'stroke-red-500',
            $this->attributes->get('orange') => 'stroke-orange-500',
            $this->attributes->get('amber') => 'stroke-amber-500',
            $this->attributes->get('yellow') => 'stroke-yellow-500',
            $this->attributes->get('lime') => 'stroke-lime-500',
            $this->attributes->get('green') => 'stroke-green-500',
            $this->attributes->get('emerald') => 'stroke-emerald-500',
            $this->attributes->get('teal') => 'stroke-teal-500',
            $this->attributes->get('cyan') => 'stroke-cyan-500',
            $this->attributes->get('sky') => 'stroke-sky-500',
            $this->attributes->get('blue') => 'stroke-blue-500',
            $this->attributes->get('indigo') => 'stroke-indigo-500',
            $this->attributes->get('violet') => 'stroke-violet-500',
            $this->attributes->get('purple') => 'stroke-purple-500',
            $this->attributes->get('fuchsia') => 'stroke-fuchsia-500',
            $this->attributes->get('pink') => 'stroke-pink-500',
            $this->attributes->get('rose') => 'stroke-rose-500',
            default => 'stroke-primary'
        };
    }
}
