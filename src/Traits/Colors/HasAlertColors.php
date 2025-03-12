<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasAlertColors
{
    use HasColorAttributes;

    public function getAlertClasses(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'text-secondary border-secondary/20 bg-secondary/10 dark:bg-secondary/15 dark:border-secondary/50 dark:text-secondary',
            $this->attributes->get('black') => 'text-black-800 border-black-200 bg-black-50 dark:bg-black-800/20 dark:border-black-900 dark:text-black-500',
            $this->attributes->get('white') => 'text-white-800 border-white-200 bg-white-50 dark:bg-white-800/20 dark:border-white-900 dark:text-white-500',
            $this->attributes->get('slate') => 'text-slate-800 border-slate-200 bg-slate-50 dark:bg-slate-800/20 dark:border-slate-900 dark:text-slate-500',
            $this->attributes->get('gray') => 'text-gray-800 border-gray-200 bg-gray-50 dark:bg-gray-800/20 dark:border-gray-900 dark:text-gray-500',
            $this->attributes->get('zinc') => 'text-zinc-800 border-zinc-200 bg-zinc-50 dark:bg-zinc-800/20 dark:border-zinc-900 dark:text-zinc-500',
            $this->attributes->get('neutral') => 'text-neutral-800 border-neutral-200 bg-neutral-50 dark:bg-neutral-800/20 dark:border-neutral-900 dark:text-neutral-500',
            $this->attributes->get('stone') => 'text-stone-800 border-stone-200 bg-stone-50 dark:bg-stone-800/20 dark:border-stone-900 dark:text-stone-500',
            $this->attributes->get('red') => 'text-red-800 border-red-200 bg-red-50 dark:bg-red-800/20 dark:border-red-900 dark:text-red-500',
            $this->attributes->get('orange') => 'text-orange-800 border-orange-200 bg-orange-50 dark:bg-orange-800/20 dark:border-orange-900 dark:text-orange-500',
            $this->attributes->get('amber') => 'text-amber-800 border-amber-200 bg-amber-50 dark:bg-amber-800/20 dark:border-amber-900 dark:text-amber-500',
            $this->attributes->get('yellow') => 'text-yellow-800 border-yellow-200 bg-yellow-50 dark:bg-yellow-800/20 dark:border-yellow-900 dark:text-yellow-500',
            $this->attributes->get('lime') => 'text-lime-800 border-lime-200 bg-lime-50 dark:bg-lime-800/20 dark:border-lime-900 dark:text-lime-500',
            $this->attributes->get('green') => 'text-green-800 border-green-200 bg-green-50 dark:bg-green-800/20 dark:border-green-900 dark:text-green-500',
            $this->attributes->get('emerald') => 'text-emerald-800 border-emerald-200 bg-emerald-50 dark:bg-emerald-800/20 dark:border-emerald-900 dark:text-emerald-500',
            $this->attributes->get('teal') => 'text-teal-800 border-teal-200 bg-teal-50 dark:bg-teal-800/20 dark:border-teal-900 dark:text-teal-500',
            $this->attributes->get('cyan') => 'text-cyan-800 border-cyan-200 bg-cyan-50 dark:bg-cyan-800/20 dark:border-cyan-900 dark:text-cyan-500',
            $this->attributes->get('sky') => 'text-sky-800 border-sky-200 bg-sky-50 dark:bg-sky-800/20 dark:border-sky-900 dark:text-sky-500',
            $this->attributes->get('blue') => 'text-blue-800 border-blue-200 bg-blue-50 dark:bg-blue-800/20 dark:border-blue-900 dark:text-blue-500',
            $this->attributes->get('indigo') => 'text-indigo-800 border-indigo-200 bg-indigo-50 dark:bg-indigo-800/20 dark:border-indigo-900 dark:text-indigo-500',
            $this->attributes->get('violet') => 'text-violet-800 border-violet-200 bg-violet-50 dark:bg-violet-800/20 dark:border-violet-900 dark:text-violet-500',
            $this->attributes->get('purple') => 'text-purple-800 border-purple-200 bg-purple-50 dark:bg-purple-800/20 dark:border-purple-900 dark:text-purple-500',
            $this->attributes->get('fuchsia') => 'text-fuchsia-800 border-fuchsia-200 bg-fuchsia-50 dark:bg-fuchsia-800/20 dark:border-fuchsia-900 dark:text-fuchsia-500',
            $this->attributes->get('pink') => 'text-pink-800 border-pink-200 bg-pink-50 dark:bg-pink-800/20 dark:border-pink-900 dark:text-pink-500',
            $this->attributes->get('rose') => 'text-rose-800 border-rose-200 bg-rose-50 dark:bg-rose-800/20 dark:border-rose-900 dark:text-rose-500',
            default => 'text-primary border-primary/20 bg-primary/10 dark:bg-primary/20 dark:border-primary dark:text-primary/80', // primary
        };
    }

    public function getAlertTextColor(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'text-secondary dark:text-secondary',
            $this->attributes->get('black') => 'text-black-700 dark:text-black-400',
            $this->attributes->get('white') => 'text-white-700 dark:text-white-400',
            $this->attributes->get('slate') => 'text-slate-700 dark:text-slate-400',
            $this->attributes->get('gray') => 'text-gray-700 dark:text-gray-400',
            $this->attributes->get('zinc') => 'text-zinc-700 dark:text-zinc-400',
            $this->attributes->get('neutral') => 'text-neutral-700 dark:text-neutral-400',
            $this->attributes->get('stone') => 'text-stone-700 dark:text-stone-400',
            $this->attributes->get('red') => 'text-red-700 dark:text-red-400',
            $this->attributes->get('orange') => 'text-orange-700 dark:text-orange-400',
            $this->attributes->get('amber') => 'text-amber-700 dark:text-amber-400',
            $this->attributes->get('yellow') => 'text-yellow-700 dark:text-yellow-400',
            $this->attributes->get('lime') => 'text-lime-700 dark:text-lime-400',
            $this->attributes->get('green') => 'text-green-700 dark:text-green-400',
            $this->attributes->get('emerald') => 'text-emerald-700 dark:text-emerald-400',
            $this->attributes->get('teal') => 'text-teal-700 dark:text-teal-400',
            $this->attributes->get('cyan') => 'text-cyan-700 dark:text-cyan-400',
            $this->attributes->get('sky') => 'text-sky-700 dark:text-sky-400',
            $this->attributes->get('blue') => 'text-blue-700 dark:text-blue-400',
            $this->attributes->get('indigo') => 'text-indigo-700 dark:text-indigo-400',
            $this->attributes->get('violet') => 'text-violet-700 dark:text-violet-400',
            $this->attributes->get('purple') => 'text-purple-700 dark:text-purple-400',
            $this->attributes->get('fuchsia') => 'text-fuchsia-700 dark:text-fuchsia-400',
            $this->attributes->get('pink') => 'text-pink-700 dark:text-pink-400',
            $this->attributes->get('rose') => 'text-rose-700 dark:text-rose-400',
            default => 'text-primary dark:text-primary', // primary
        };
    }

    public function getAlertActionColors(): string
    {
        return match (true) {
            $this->attributes->get('secondary') => 'text-secondary hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->attributes->get('black') => 'text-black-600 hover:bg-black-500/10 focus:bg-black-500/15 focus:ring-black-500',
            $this->attributes->get('white') => 'text-white-600 hover:bg-white-500/10 focus:bg-white-500/15 focus:ring-white-500',
            $this->attributes->get('slate') => 'text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->attributes->get('gray') => 'text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->attributes->get('zinc') => 'text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->attributes->get('neutral') => 'text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->attributes->get('stone') => 'text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->attributes->get('red') => 'text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->attributes->get('orange') => 'text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->attributes->get('amber') => 'text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->attributes->get('yellow') => 'text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->attributes->get('lime') => 'text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->attributes->get('green') => 'text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->attributes->get('emerald') => 'text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->attributes->get('teal') => 'text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->attributes->get('cyan') => 'text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->attributes->get('sky') => 'text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->attributes->get('blue') => 'text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->attributes->get('indigo') => 'text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->attributes->get('violet') => 'text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->attributes->get('purple') => 'text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->attributes->get('fuchsia') => 'text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->attributes->get('pink') => 'text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->attributes->get('rose') => 'text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => 'text-primary hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70', // primary
        };
    }
}
