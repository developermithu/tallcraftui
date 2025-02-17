<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasButtonColors
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

    private function isPrimaryWithoutOthers(): bool
    {
        return $this->primary
            && ! $this->attributes->has('secondary')
            && ! $this->attributes->has('black')
            && ! $this->attributes->has('white')
            && ! $this->attributes->has('slate')
            && ! $this->attributes->has('gray')
            && ! $this->attributes->has('zinc')
            && ! $this->attributes->has('neutral')
            && ! $this->attributes->has('stone')
            && ! $this->attributes->has('red')
            && ! $this->attributes->has('orange')
            && ! $this->attributes->has('amber')
            && ! $this->attributes->has('yellow')
            && ! $this->attributes->has('lime')
            && ! $this->attributes->has('green')
            && ! $this->attributes->has('emerald')
            && ! $this->attributes->has('teal')
            && ! $this->attributes->has('cyan')
            && ! $this->attributes->has('sky')
            && ! $this->attributes->has('blue')
            && ! $this->attributes->has('indigo')
            && ! $this->attributes->has('violet')
            && ! $this->attributes->has('purple')
            && ! $this->attributes->has('fuchsia')
            && ! $this->attributes->has('pink')
            && ! $this->attributes->has('rose');
    }

    public function getColorClasses(): string
    {
        $notOtherStyle = ! $this->attributes->has('outline') && !$this->attributes->has('flat');

        return match (true) {
            $this->isPrimaryWithoutOthers() && $notOtherStyle => 'bg-primary/90 text-white hover:bg-primary focus:bg-primary focus:ring-primary',
            $this->attributes->has('secondary') && $notOtherStyle => 'bg-secondary/90 text-white hover:bg-secondary focus:bg-secondary focus:ring-secondary',
            $this->attributes->has('black') && $notOtherStyle => 'bg-black text-white hover:bg-black/90 focus:bg-black/90 focus:ring-black/70',
            $this->attributes->has('white') && $notOtherStyle => 'bg-black/5 dark:bg-white text-gray-500 dark:text-gray-700 hover:bg-black/10 dark:hover:bg-white/90 focus:bg-black/15 dark:focus:bg-white/90 focus:ring-black/20 dark:focus:ring-white/70',
            $this->attributes->has('slate') && $notOtherStyle => 'bg-slate-600 text-white hover:bg-slate-700 focus:bg-slate-700 focus:ring-slate-500',
            $this->attributes->has('gray') && $notOtherStyle => 'bg-gray-600 text-white hover:bg-gray-700 focus:bg-gray-700 focus:ring-gray-500',
            $this->attributes->has('zinc') && $notOtherStyle => 'bg-zinc-600 text-white hover:bg-zinc-700 focus:bg-zinc-700 focus:ring-zinc-500',
            $this->attributes->has('neutral') && $notOtherStyle => 'bg-neutral-600 text-white hover:bg-neutral-700 focus:bg-neutral-700 focus:ring-neutral-500',
            $this->attributes->has('stone') && $notOtherStyle => 'bg-stone-600 text-white hover:bg-stone-700 focus:bg-stone-700 focus:ring-stone-500',
            $this->attributes->has('red') && $notOtherStyle => 'bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500',
            $this->attributes->has('orange') && $notOtherStyle => 'bg-orange-600 text-white hover:bg-orange-700 focus:bg-orange-700 focus:ring-orange-500',
            $this->attributes->has('amber') && $notOtherStyle => 'bg-amber-600 text-white hover:bg-amber-700 focus:bg-amber-700 focus:ring-amber-500',
            $this->attributes->has('yellow') && $notOtherStyle => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500',
            $this->attributes->has('lime') && $notOtherStyle => 'bg-lime-600 text-white hover:bg-lime-700 focus:bg-lime-700 focus:ring-lime-500',
            $this->attributes->has('green') && $notOtherStyle => 'bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500',
            $this->attributes->has('emerald') && $notOtherStyle => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:bg-emerald-700 focus:ring-emerald-500',
            $this->attributes->has('teal') && $notOtherStyle => 'bg-teal-600 text-white hover:bg-teal-700 focus:bg-teal-700 focus:ring-teal-500',
            $this->attributes->has('cyan') && $notOtherStyle => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:ring-cyan-500',
            $this->attributes->has('sky') && $notOtherStyle => 'bg-sky-600 text-white hover:bg-sky-700 focus:bg-sky-700 focus:ring-sky-500',
            $this->attributes->has('blue') && $notOtherStyle => 'bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500',
            $this->attributes->has('indigo') && $notOtherStyle => 'bg-indigo-600 text-white hover:bg-indigo-700 focus:bg-indigo-700 focus:ring-indigo-500',
            $this->attributes->has('violet') && $notOtherStyle => 'bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500',
            $this->attributes->has('purple') && $notOtherStyle => 'bg-purple-600 text-white hover:bg-purple-700 focus:bg-purple-700 focus:ring-purple-500',
            $this->attributes->has('fuchsia') && $notOtherStyle => 'bg-fuchsia-600 text-white hover:bg-fuchsia-700 focus:bg-fuchsia-700 focus:ring-fuchsia-500',
            $this->attributes->has('pink') && $notOtherStyle => 'bg-pink-600 text-white hover:bg-pink-700 focus:bg-pink-700 focus:ring-pink-500',
            $this->attributes->has('rose') && $notOtherStyle => 'bg-rose-600 text-white hover:bg-rose-700 focus:bg-rose-700 focus:ring-rose-500',
            default => '',
        };
    }

    public function getOutlineClasses(): string
    {
        return match (true) {
            $this->attributes->has('outline') && $this->isPrimaryWithoutOthers() => 'bg-transparent focus:border-transparent border-primary/40 dark:border-primary/90 text-primary/90 hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70',
            $this->attributes->has('outline') && $this->attributes->has('secondary') => 'bg-transparent focus:border-transparent border-secondary/40 dark:border-secondary/90 text-secondary/90 hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->attributes->has('outline') && $this->attributes->has('black') => 'bg-transparent focus:border-transparent border-black/20 dark:border-black/80 dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/60',
            $this->attributes->has('outline') && $this->attributes->has('white') => 'bg-transparent focus:border-transparent border-gray-200 dark:border-white text-black/20 dark:text-white/60 hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 dark:focus:ring-white/80 focus:ring-black/20',
            $this->attributes->has('outline') && $this->attributes->has('slate') => 'bg-transparent focus:border-transparent border-slate-300 dark:border-slate-600 text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->attributes->has('outline') && $this->attributes->has('gray') => 'bg-transparent focus:border-transparent border-gray-300 dark:border-gray-600 text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->attributes->has('outline') && $this->attributes->has('zinc') => 'bg-transparent focus:border-transparent border-zinc-300 dark:border-zinc-600 text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->attributes->has('outline') && $this->attributes->has('neutral') => 'bg-transparent focus:border-transparent border-neutral-300 dark:border-neutral-600 text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->attributes->has('outline') && $this->attributes->has('stone') => 'bg-transparent focus:border-transparent border-stone-300 dark:border-stone-600 text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->attributes->has('outline') && $this->attributes->has('red') => 'bg-transparent focus:border-transparent border-red-300 dark:border-red-600 text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->attributes->has('outline') && $this->attributes->has('orange') => 'bg-transparent focus:border-transparent border-orange-300 dark:border-orange-600 text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->attributes->has('outline') && $this->attributes->has('amber') => 'bg-transparent focus:border-transparent border-amber-300 dark:border-amber-600 text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->attributes->has('outline') && $this->attributes->has('yellow') => 'bg-transparent focus:border-transparent border-yellow-300 dark:border-yellow-600 text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->attributes->has('outline') && $this->attributes->has('lime') => 'bg-transparent focus:border-transparent border-lime-300 dark:border-lime-600 text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->attributes->has('outline') && $this->attributes->has('green') => 'bg-transparent focus:border-transparent border-green-300 dark:border-green-600 text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->attributes->has('outline') && $this->attributes->has('emerald') => 'bg-transparent focus:border-transparent border-emerald-300 dark:border-emerald-600 text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->attributes->has('outline') && $this->attributes->has('teal') => 'bg-transparent focus:border-transparent border-teal-300 dark:border-teal-600 text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->attributes->has('outline') && $this->attributes->has('cyan') => 'bg-transparent focus:border-transparent border-cyan-300 dark:border-cyan-600 text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->attributes->has('outline') && $this->attributes->has('sky') => 'bg-transparent focus:border-transparent border-sky-300 dark:border-sky-600 text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->attributes->has('outline') && $this->attributes->has('blue') => 'bg-transparent focus:border-transparent border-blue-300 dark:border-blue-600 text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->attributes->has('outline') && $this->attributes->has('indigo') => 'bg-transparent focus:border-transparent border-indigo-300 dark:border-indigo-600 text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->attributes->has('outline') && $this->attributes->has('violet') => 'bg-transparent focus:border-transparent border-violet-300 dark:border-violet-600 text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->attributes->has('outline') && $this->attributes->has('purple') => 'bg-transparent focus:border-transparent border-purple-300 dark:border-purple-600 text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->attributes->has('outline') && $this->attributes->has('fuchsia') => 'bg-transparent focus:border-transparent border-fuchsia-300 dark:border-fuchsia-600 text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->attributes->has('outline') && $this->attributes->has('pink') => 'bg-transparent focus:border-transparent border-pink-300 dark:border-pink-600 text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->attributes->has('outline') && $this->attributes->has('rose') => 'bg-transparent focus:border-transparent border-rose-300 dark:border-rose-600 text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }

    public function getFlatClasses(): string
    {
        return match (true) {
            $this->attributes->has('flat') && $this->isPrimaryWithoutOthers() => 'bg-transparent text-primary hover:bg-primary/10 focus:bg-primary/15 focus:ring-primary/70',
            $this->attributes->has('flat') && $this->attributes->has('secondary') => 'bg-transparent text-secondary hover:bg-secondary/10 focus:bg-secondary/15 focus:ring-secondary/70',
            $this->attributes->has('flat') && $this->attributes->has('black') => 'bg-transparent dark:text-white/20 text-black hover:bg-black/10 focus:bg-black/15 focus:ring-black/80',
            $this->attributes->has('flat') && $this->attributes->has('white') => 'bg-transparent text-black/20 dark:text-white hover:bg-black/5 dark:hover:bg-white/10 focus:bg-black/10 dark:focus:bg-white/15 focus:ring-black/20 dark:focus:ring-white/80',
            $this->attributes->has('flat') && $this->attributes->has('slate') => 'bg-transparent text-slate-600 hover:bg-slate-500/10 focus:bg-slate-500/15 focus:ring-slate-500',
            $this->attributes->has('flat') && $this->attributes->has('gray') => 'bg-transparent text-gray-600 hover:bg-gray-500/10 focus:bg-gray-500/15 focus:ring-gray-500',
            $this->attributes->has('flat') && $this->attributes->has('zinc') => 'bg-transparent text-zinc-600 hover:bg-zinc-500/10 focus:bg-zinc-500/15 focus:ring-zinc-500',
            $this->attributes->has('flat') && $this->attributes->has('neutral') => 'bg-transparent text-neutral-600 hover:bg-neutral-500/10 focus:bg-neutral-500/15 focus:ring-neutral-500',
            $this->attributes->has('flat') && $this->attributes->has('stone') => 'bg-transparent text-stone-600 hover:bg-stone-500/10 focus:bg-stone-500/15 focus:ring-stone-500',
            $this->attributes->has('flat') && $this->attributes->has('red') => 'bg-transparent text-red-600 hover:bg-red-500/10 focus:bg-red-500/15 focus:ring-red-500',
            $this->attributes->has('flat') && $this->attributes->has('orange') => 'bg-transparent text-orange-600 hover:bg-orange-500/10 focus:bg-orange-500/15 focus:ring-orange-500',
            $this->attributes->has('flat') && $this->attributes->has('amber') => 'bg-transparent text-amber-600 hover:bg-amber-500/10 focus:bg-amber-500/15 focus:ring-amber-500',
            $this->attributes->has('flat') && $this->attributes->has('yellow') => 'bg-transparent text-yellow-600 hover:bg-yellow-500/10 focus:bg-yellow-500/15 focus:ring-yellow-500',
            $this->attributes->has('flat') && $this->attributes->has('lime') => 'bg-transparent text-lime-600 hover:bg-lime-500/10 focus:bg-lime-500/15 focus:ring-lime-500',
            $this->attributes->has('flat') && $this->attributes->has('green') => 'bg-transparent text-green-600 hover:bg-green-500/10 focus:bg-green-500/15 focus:ring-green-500',
            $this->attributes->has('flat') && $this->attributes->has('emerald') => 'bg-transparent text-emerald-600 hover:bg-emerald-500/10 focus:bg-emerald-500/15 focus:ring-emerald-500',
            $this->attributes->has('flat') && $this->attributes->has('teal') => 'bg-transparent text-teal-600 hover:bg-teal-500/10 focus:bg-teal-500/15 focus:ring-teal-500',
            $this->attributes->has('flat') && $this->attributes->has('cyan') => 'bg-transparent text-cyan-600 hover:bg-cyan-500/10 focus:bg-cyan-500/15 focus:ring-cyan-500',
            $this->attributes->has('flat') && $this->attributes->has('sky') => 'bg-transparent text-sky-600 hover:bg-sky-500/10 focus:bg-sky-500/15 focus:ring-sky-500',
            $this->attributes->has('flat') && $this->attributes->has('blue') => 'bg-transparent text-blue-600 hover:bg-blue-500/10 focus:bg-blue-500/15 focus:ring-blue-500',
            $this->attributes->has('flat') && $this->attributes->has('indigo') => 'bg-transparent text-indigo-600 hover:bg-indigo-500/10 focus:bg-indigo-500/15 focus:ring-indigo-500',
            $this->attributes->has('flat') && $this->attributes->has('violet') => 'bg-transparent text-violet-600 hover:bg-violet-500/10 focus:bg-violet-500/15 focus:ring-violet-500',
            $this->attributes->has('flat') && $this->attributes->has('purple') => 'bg-transparent text-purple-600 hover:bg-purple-500/10 focus:bg-purple-500/15 focus:ring-purple-500',
            $this->attributes->has('flat') && $this->attributes->has('fuchsia') => 'bg-transparent text-fuchsia-600 hover:bg-fuchsia-500/10 focus:bg-fuchsia-500/15 focus:ring-fuchsia-500',
            $this->attributes->has('flat') && $this->attributes->has('pink') => 'bg-transparent text-pink-600 hover:bg-pink-500/10 focus:bg-pink-500/15 focus:ring-pink-500',
            $this->attributes->has('flat') && $this->attributes->has('rose') => 'bg-transparent text-rose-600 hover:bg-rose-500/10 focus:bg-rose-500/15 focus:ring-rose-500',
            default => '',
        };
    }
}
