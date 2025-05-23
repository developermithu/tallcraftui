<?php

namespace Developermithu\Tallcraftui\Traits\Colors;

trait HasBadgeColors
{
    use HasColorAttributes;

    private function isPrimaryWithoutOthers(): bool
    {
        return $this->primary
            && !$this->attributes->get('secondary')
            && !$this->attributes->get('black')
            && !$this->attributes->get('white')
            && !$this->attributes->get('slate')
            && !$this->attributes->get('gray')
            && !$this->attributes->get('zinc')
            && !$this->attributes->get('neutral')
            && !$this->attributes->get('stone')
            && !$this->attributes->get('red')
            && !$this->attributes->get('orange')
            && !$this->attributes->get('amber')
            && !$this->attributes->get('yellow')
            && !$this->attributes->get('lime')
            && !$this->attributes->get('green')
            && !$this->attributes->get('emerald')
            && !$this->attributes->get('teal')
            && !$this->attributes->get('cyan')
            && !$this->attributes->get('sky')
            && !$this->attributes->get('blue')
            && !$this->attributes->get('indigo')
            && !$this->attributes->get('violet')
            && !$this->attributes->get('purple')
            && !$this->attributes->get('fuchsia')
            && !$this->attributes->get('pink')
            && !$this->attributes->get('rose');
    }

    public function getColorClasses(): string
    {
        $notOtherStyle = !$this->attributes->get('outline');

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-primary/10 text-primary',
            $this->attributes->get('secondary') && $notOtherStyle => 'bg-secondary/10 text-secondary',
            $this->attributes->get('black') && $notOtherStyle => 'bg-black text-white',
            $this->attributes->get('white') && $notOtherStyle => 'bg-gray-50 text-gray-700',
            $this->attributes->get('slate') && $notOtherStyle => 'bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-400',
            $this->attributes->get('gray') && $notOtherStyle => 'bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
            $this->attributes->get('zinc') && $notOtherStyle => 'bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-400',
            $this->attributes->get('neutral') && $notOtherStyle => 'bg-neutral-200 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-400',
            $this->attributes->get('stone') && $notOtherStyle => 'bg-stone-200 dark:bg-stone-800 text-stone-700 dark:text-stone-400',
            $this->attributes->get('red') && $notOtherStyle => 'bg-red-200 dark:bg-red-800/50 text-red-700 dark:text-red-500',
            $this->attributes->get('orange') && $notOtherStyle => 'bg-orange-200 dark:bg-orange-800/50 text-orange-700 dark:text-orange-500',
            $this->attributes->get('amber') && $notOtherStyle => 'bg-amber-200 dark:bg-amber-800/50 text-amber-700 dark:text-amber-500',
            $this->attributes->get('yellow') && $notOtherStyle => 'bg-yellow-200 dark:bg-yellow-800/50 text-yellow-700 dark:text-yellow-500',
            $this->attributes->get('lime') && $notOtherStyle => 'bg-lime-200 dark:bg-lime-800/50 text-lime-700 dark:text-lime-500',
            $this->attributes->get('green') && $notOtherStyle => 'bg-green-200 dark:bg-green-800/50 text-green-700 dark:text-green-500',
            $this->attributes->get('emerald') && $notOtherStyle => 'bg-emerald-200 dark:bg-emerald-800/50 text-emerald-700 dark:text-emerald-500',
            $this->attributes->get('teal') && $notOtherStyle => 'bg-teal-200 dark:bg-teal-800/50 text-teal-700 dark:text-teal-500',
            $this->attributes->get('cyan') && $notOtherStyle => 'bg-cyan-200 dark:bg-cyan-800/50 text-cyan-700 dark:text-cyan-500',
            $this->attributes->get('sky') && $notOtherStyle => 'bg-sky-200 dark:bg-sky-800/50 text-sky-700 dark:text-sky-500',
            $this->attributes->get('blue') && $notOtherStyle => 'bg-blue-200 dark:bg-blue-800/50 text-blue-700 dark:text-blue-500',
            $this->attributes->get('indigo') && $notOtherStyle => 'bg-indigo-200 dark:bg-indigo-800/50 text-indigo-700 dark:text-indigo-500',
            $this->attributes->get('violet') && $notOtherStyle => 'bg-violet-200 dark:bg-violet-800/50 text-violet-700 dark:text-violet-500',
            $this->attributes->get('purple') && $notOtherStyle => 'bg-purple-200 dark:bg-purple-800/50 text-purple-700 dark:text-purple-500',
            $this->attributes->get('fuchsia') && $notOtherStyle => 'bg-fuchsia-200 dark:bg-fuchsia-800/50 text-fuchsia-700 dark:text-fuchsia-500',
            $this->attributes->get('pink') && $notOtherStyle => 'bg-pink-200 dark:bg-pink-800/50 text-pink-700 dark:text-pink-500',
            $this->attributes->get('rose') && $notOtherStyle => 'bg-rose-200 dark:bg-rose-800/50 text-rose-700 dark:text-rose-500',
            default => '',
        };
    }

    public function getOutlineClasses(): string
    {
        return match (true) {
            $this->attributes->get('outline') && $this->isPrimaryWithoutOthers() => 'bg-transparent text-primary border border-primary',
            $this->attributes->get('outline') && $this->attributes->get('secondary') => 'bg-transparent text-secondary border border-secondary',
            $this->attributes->get('outline') && $this->attributes->get('black') => 'bg-transparent text-black border border-black',
            $this->attributes->get('outline') && $this->attributes->get('white') => 'bg-transparent text-gray-600 dark:text-white border border-gray-200 dark:border-white',
            $this->attributes->get('outline') && $this->attributes->get('slate') => 'bg-transparent text-slate-600 dark:text-slate-400 border border-slate-500 dark:border-slate-400',
            $this->attributes->get('outline') && $this->attributes->get('gray') => 'bg-transparent text-gray-600 dark:text-gray-400 border border-gray-500 dark:border-gray-400',
            $this->attributes->get('outline') && $this->attributes->get('zinc') => 'bg-transparent text-zinc-600 dark:text-zinc-400 border border-zinc-500 dark:border-zinc-400',
            $this->attributes->get('outline') && $this->attributes->get('neutral') => 'bg-transparent text-neutral-600 dark:text-neutral-400 border border-neutral-500 dark:border-neutral-400',
            $this->attributes->get('outline') && $this->attributes->get('stone') => 'bg-transparent text-stone-600 dark:text-stone-400 border border-stone-500 dark:border-stone-400',
            $this->attributes->get('outline') && $this->attributes->get('red') => 'bg-transparent text-red-600 border border-red-500',
            $this->attributes->get('outline') && $this->attributes->get('orange') => 'bg-transparent text-orange-600 border border-orange-500',
            $this->attributes->get('outline') && $this->attributes->get('amber') => 'bg-transparent text-amber-600 border border-amber-500',
            $this->attributes->get('outline') && $this->attributes->get('yellow') => 'bg-transparent text-yellow-600 border border-yellow-500',
            $this->attributes->get('outline') && $this->attributes->get('lime') => 'bg-transparent text-lime-600 border border-lime-500',
            $this->attributes->get('outline') && $this->attributes->get('green') => 'bg-transparent text-green-600 border border-green-500',
            $this->attributes->get('outline') && $this->attributes->get('emerald') => 'bg-transparent text-emerald-600 border border-emerald-500',
            $this->attributes->get('outline') && $this->attributes->get('teal') => 'bg-transparent text-teal-600 border border-teal-500',
            $this->attributes->get('outline') && $this->attributes->get('cyan') => 'bg-transparent text-cyan-600 border border-cyan-500',
            $this->attributes->get('outline') && $this->attributes->get('sky') => 'bg-transparent text-sky-600 border border-sky-500',
            $this->attributes->get('outline') && $this->attributes->get('blue') => 'bg-transparent text-blue-600 border border-blue-500',
            $this->attributes->get('outline') && $this->attributes->get('indigo') => 'bg-transparent text-indigo-600 border border-indigo-500',
            $this->attributes->get('outline') && $this->attributes->get('violet') => 'bg-transparent text-violet-600 border border-violet-500',
            $this->attributes->get('outline') && $this->attributes->get('purple') => 'bg-transparent text-purple-600 border border-purple-500',
            $this->attributes->get('outline') && $this->attributes->get('fuchsia') => 'bg-transparent text-fuchsia-600 border border-fuchsia-500',
            $this->attributes->get('outline') && $this->attributes->get('pink') => 'bg-transparent text-pink-600 border border-pink-500',
            $this->attributes->get('outline') && $this->attributes->get('rose') => 'bg-transparent text-rose-600 border border-rose-500',
            default => '',
        };
    }
}
