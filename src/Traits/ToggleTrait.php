<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Traits\Colors\HasColorAttributes;

trait ToggleTrait
{
    use HasColorAttributes;
    
    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'peer-focus:ring-secondary dark:peer-focus:ring-secondary peer-checked:bg-secondary',
            $this->attributes->get('black') => 'peer-focus:ring-gray-900 dark:peer-focus:ring-gray-900 peer-checked:bg-gray-900',
            $this->attributes->get('white') => 'peer-focus:ring-gray-50 dark:peer-focus:ring-gray-50 peer-checked:bg-gray-50 dark:peer-checked:bg-gray-300',
            $this->attributes->get('slate') => 'peer-focus:ring-slate-500 dark:peer-focus:ring-slate-500 peer-checked:bg-slate-500',
            $this->attributes->get('gray') => 'peer-focus:ring-gray-500 dark:peer-focus:ring-gray-500 peer-checked:bg-gray-500',
            $this->attributes->get('zinc') => 'peer-focus:ring-zinc-500 dark:peer-focus:ring-zinc-500 peer-checked:bg-zinc-500',
            $this->attributes->get('neutral') => 'peer-focus:ring-neutral-500 dark:peer-focus:ring-neutral-500 peer-checked:bg-neutral-500',
            $this->attributes->get('stone') => 'peer-focus:ring-stone-500 dark:peer-focus:ring-stone-500 peer-checked:bg-stone-500',
            $this->attributes->get('red') => 'peer-focus:ring-red-500 dark:peer-focus:ring-red-500 peer-checked:bg-red-500',
            $this->attributes->get('orange') => 'peer-focus:ring-orange-500 dark:peer-focus:ring-orange-500 peer-checked:bg-orange-500',
            $this->attributes->get('amber') => 'peer-focus:ring-amber-500 dark:peer-focus:ring-amber-500 peer-checked:bg-amber-500',
            $this->attributes->get('yellow') => 'peer-focus:ring-yellow-500 dark:peer-focus:ring-yellow-500 peer-checked:bg-yellow-500',
            $this->attributes->get('lime') => 'peer-focus:ring-lime-500 dark:peer-focus:ring-lime-500 peer-checked:bg-lime-500',
            $this->attributes->get('green') => 'peer-focus:ring-green-500 dark:peer-focus:ring-green-500 peer-checked:bg-green-500',
            $this->attributes->get('emerald') => 'peer-focus:ring-emerald-500 dark:peer-focus:ring-emerald-500 peer-checked:bg-emerald-500',
            $this->attributes->get('teal') => 'peer-focus:ring-teal-500 dark:peer-focus:ring-teal-500 peer-checked:bg-teal-500',
            $this->attributes->get('cyan') => 'peer-focus:ring-cyan-500 dark:peer-focus:ring-cyan-500 peer-checked:bg-cyan-500',
            $this->attributes->get('sky') => 'peer-focus:ring-sky-500 dark:peer-focus:ring-sky-500 peer-checked:bg-sky-500',
            $this->attributes->get('blue') => 'peer-focus:ring-blue-500 dark:peer-focus:ring-blue-500 peer-checked:bg-blue-500',
            $this->attributes->get('indigo') => 'peer-focus:ring-indigo-500 dark:peer-focus:ring-indigo-500 peer-checked:bg-indigo-500',
            $this->attributes->get('violet') => 'peer-focus:ring-violet-500 dark:peer-focus:ring-violet-500 peer-checked:bg-violet-500',
            $this->attributes->get('purple') => 'peer-focus:ring-purple-500 dark:peer-focus:ring-purple-500 peer-checked:bg-purple-500',
            $this->attributes->get('fuchsia') => 'peer-focus:ring-fuchsia-500 dark:peer-focus:ring-fuchsia-500 peer-checked:bg-fuchsia-500',
            $this->attributes->get('pink') => 'peer-focus:ring-pink-500 dark:peer-focus:ring-pink-500 peer-checked:bg-pink-500',
            $this->attributes->get('rose') => 'peer-focus:ring-rose-500 dark:peer-focus:ring-rose-500 peer-checked:bg-rose-500',
            default => 'peer-focus:ring-primary dark:peer-focus:ring-primary peer-checked:bg-primary', // primary
        };
    }

    public function getSizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'w-9 h-5 after:h-4 after:w-4 after:start-[2px]',
            $this->attributes->get('md') => 'w-11 h-6 after:h-5 after:w-5 after:start-[2px]',
            $this->attributes->get('lg') => 'w-14 h-7 after:h-6 after:w-6 after:start-[4px]',
            default => 'w-11 h-6 after:h-5 after:w-5 after:start-[2px]', // md
        };
    }
}