<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;

trait AvatarsTrait
{
    public function getSizeClasses(): string
    {
        $sizeClasses = match (true) {
            $this->attributes->get('sm') => 'size-8 text-xs',
            $this->attributes->get('md') => 'size-[38px] text-sm',
            $this->attributes->get('lg') => 'size-[46px] text-base',
            $this->attributes->get('xl') => 'size-[62px] text-lg',
            default => 'size-[38px] text-sm',
        };

        return "{$sizeClasses}";
    }

    public function getRingColor(): string
    {
        return match ($this->ringColor) {
            'primary' => 'ring-primary',
            'secondary' => 'ring-secondary',
            'black' => 'ring-black',
            'white' => 'ring-white',
            'slate' => 'ring-slate-400',
            'gray' => 'ring-gray-400',
            'zinc' => 'ring-zinc-400',
            'neutral' => 'ring-neutral-400',
            'stone' => 'ring-stone-400',
            'red' => 'ring-red-400',
            'orange' => 'ring-orange-400',
            'amber' => 'ring-amber-400',
            'yellow' => 'ring-yellow-400',
            'lime' => 'ring-lime-400',
            'green' => 'ring-green-400',
            'emerald' => 'ring-emerald-400',
            'teal' => 'ring-teal-400',
            'cyan' => 'ring-cyan-400',
            'sky' => 'ring-sky-400',
            'blue' => 'ring-blue-400',
            'indigo' => 'ring-indigo-400',
            'violet' => 'ring-violet-400',
            'purple' => 'ring-purple-400',
            'fuchsia' => 'ring-fuchsia-400',
            'pink' => 'ring-pink-400',
            'rose' => 'ring-rose-400',
            default => 'ring-primary',
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('avatar', $this->attributes);
    }
}