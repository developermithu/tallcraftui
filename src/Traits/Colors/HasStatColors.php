<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasStatColors
{
    use HasColorAttributes;

    public function getColorClasses(): string
    {
        return match (true) {
            $this->attributes->get('primary') => 'border-primary/40',
            $this->attributes->get('secondary') => 'border-secondary/40',
            $this->attributes->get('black') => 'border-black-500/40',
            $this->attributes->get('white') => 'border-white-500/40',
            $this->attributes->get('slate') => 'border-slate-500/40',
            $this->attributes->get('gray') => 'border-gray-500/40',
            $this->attributes->get('zinc') => 'border-zinc-500/40',
            $this->attributes->get('neutral') => 'border-neutral-500/40',
            $this->attributes->get('stone') => 'border-stone-500/40',
            $this->attributes->get('red') => 'border-red-500/40',
            $this->attributes->get('orange') => 'border-orange-500/40',
            $this->attributes->get('amber') => 'border-amber-500/40',
            $this->attributes->get('yellow') => 'border-yellow-500/40',
            $this->attributes->get('lime') => 'border-lime-500/40',
            $this->attributes->get('green') => 'border-green-500/40',
            $this->attributes->get('emerald') => 'border-emerald-500/40',
            $this->attributes->get('teal') => 'border-teal-500/40',
            $this->attributes->get('cyan') => 'border-cyan-500/40',
            $this->attributes->get('sky') => 'border-sky-500/40',
            $this->attributes->get('blue') => 'border-blue-500/40',
            $this->attributes->get('indigo') => 'border-indigo-500/40',
            $this->attributes->get('violet') => 'border-violet-500/40',
            $this->attributes->get('purple') => 'border-purple-500/40',
            $this->attributes->get('fuchsia') => 'border-fuchsia-500/40',
            $this->attributes->get('pink') => 'border-pink-500/40',
            $this->attributes->get('rose') => 'border-rose-500/40',
            default => 'border-gray-200 dark:border-gray-600',
        };
    }

    public function getIconBgColor(): string
    {
        return match (true) {
            $this->attributes->get('primary') => 'bg-primary/20 dark:bg-primary/50 dark:text-gray-200',
            $this->attributes->get('secondary') => 'bg-secondary/20 dark:bg-secondary/50 dark:text-gray-200',
            $this->attributes->get('black') => 'bg-black-500/20 dark:bg-black-500/50 dark:text-gray-200',
            $this->attributes->get('white') => 'bg-white-500/20 dark:bg-white-500/50 dark:text-gray-200',
            $this->attributes->get('slate') => 'bg-slate-500/20 dark:bg-slate-500/50 dark:text-gray-200',
            $this->attributes->get('gray') => 'bg-gray-500/20 dark:bg-gray-500/50 dark:text-gray-200',
            $this->attributes->get('zinc') => 'bg-zinc-500/20 dark:bg-zinc-500/50 dark:text-gray-200',
            $this->attributes->get('neutral') => 'bg-neutral-500/20 dark:bg-neutral-500/50 dark:text-gray-200',
            $this->attributes->get('stone') => 'bg-stone-500/20 dark:bg-stone-500/50 dark:text-gray-200',
            $this->attributes->get('red') => 'bg-red-500/20 dark:bg-red-500/50 dark:text-gray-200',
            $this->attributes->get('orange') => 'bg-orange-500/20 dark:bg-orange-500/50 dark:text-gray-200',
            $this->attributes->get('amber') => 'bg-amber-500/20 dark:bg-amber-500/50 dark:text-gray-200',
            $this->attributes->get('yellow') => 'bg-yellow-500/20 dark:bg-yellow-500/50 dark:text-gray-200',
            $this->attributes->get('lime') => 'bg-lime-500/20 dark:bg-lime-500/50 dark:text-gray-200',
            $this->attributes->get('green') => 'bg-green-500/20 dark:bg-green-500/50 dark:text-gray-200',
            $this->attributes->get('emerald') => 'bg-emerald-500/20 dark:bg-emerald-500/50 dark:text-gray-200',
            $this->attributes->get('teal') => 'bg-teal-500/20 dark:bg-teal-500/50 dark:text-gray-200',
            $this->attributes->get('cyan') => 'bg-cyan-500/20 dark:bg-cyan-500/50 dark:text-gray-200',
            $this->attributes->get('sky') => 'bg-sky-500/20 dark:bg-sky-500/50 dark:text-gray-200',
            $this->attributes->get('blue') => 'bg-blue-500/20 dark:bg-blue-500/50 dark:text-gray-200',
            $this->attributes->get('indigo') => 'bg-indigo-500/20 dark:bg-indigo-500/50 dark:text-gray-200',
            $this->attributes->get('violet') => 'bg-violet-500/20 dark:bg-violet-500/50 dark:text-gray-200',
            $this->attributes->get('purple') => 'bg-purple-500/20 dark:bg-purple-500/50 dark:text-gray-200',
            $this->attributes->get('fuchsia') => 'bg-fuchsia-500/20 dark:bg-fuchsia-500/50 dark:text-gray-200',
            $this->attributes->get('pink') => 'bg-pink-500/20 dark:bg-pink-500/50 dark:text-gray-200',
            $this->attributes->get('rose') => 'bg-rose-500/20 dark:bg-rose-500/50 dark:text-gray-200',
            default => 'border-gray-200 dark:border-gray-600',
        };
    }
}