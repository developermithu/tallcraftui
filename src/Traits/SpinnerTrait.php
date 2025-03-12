<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Traits\Colors\HasColorAttributes;

trait SpinnerTrait
{
    use HasColorAttributes;

    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'text-secondary',
            $this->attributes->get('black') => 'text-gray-900',
            $this->attributes->get('white') => 'text-white',
            $this->attributes->get('slate') => 'text-slate-500',
            $this->attributes->get('gray') => 'text-gray-500',
            $this->attributes->get('zinc') => 'text-zinc-500',
            $this->attributes->get('neutral') => 'text-neutral-500',
            $this->attributes->get('stone') => 'text-stone-500',
            $this->attributes->get('red') => 'text-red-500',
            $this->attributes->get('orange') => 'text-orange-500',
            $this->attributes->get('amber') => 'text-amber-500',
            $this->attributes->get('yellow') => 'text-yellow-500',
            $this->attributes->get('lime') => 'text-lime-500',
            $this->attributes->get('green') => 'text-green-500',
            $this->attributes->get('emerald') => 'text-emerald-500',
            $this->attributes->get('teal') => 'text-teal-500',
            $this->attributes->get('cyan') => 'text-cyan-500',
            $this->attributes->get('sky') => 'text-sky-500',
            $this->attributes->get('blue') => 'text-blue-500',
            $this->attributes->get('indigo') => 'text-indigo-500',
            $this->attributes->get('violet') => 'text-violet-500',
            $this->attributes->get('purple') => 'text-purple-500',
            $this->attributes->get('fuchsia') => 'text-fuchsia-500',
            $this->attributes->get('pink') => 'text-pink-500',
            $this->attributes->get('rose') => 'text-rose-500',
            default => 'text-primary',
        };
    }

    public function getSizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('xs') => 'w-4 h-4',
            $this->attributes->get('sm') => 'w-6 h-6',
            $this->attributes->get('md') => 'w-8 h-8',
            $this->attributes->get('lg') => 'w-10 h-10',
            $this->attributes->get('xl') => 'w-12 h-12',
            default => 'w-8 h-8', // md
        };
    }
}