<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;

trait AvatarTrait
{
    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('avatar', $this->attributes);
    }

    public function getAvatarBaseClasses(): string
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

    public function getBadgeClasses(): string
    {
        $badgeColors = match (true) {
            $this->badgeColor === 'primary' => 'bg-primary',
            $this->badgeColor === 'secondary' => 'bg-secondary',
            $this->badgeColor === 'black' => 'bg-black',
            $this->badgeColor === 'white' => 'bg-white',
            $this->badgeColor === 'slate' => 'bg-slate-500',
            $this->badgeColor === 'gray' => 'bg-gray-500',
            $this->badgeColor === 'zinc' => 'bg-zinc-500',
            $this->badgeColor === 'neutral' => 'bg-neutral-500',
            $this->badgeColor === 'stone' => 'bg-stone-500',
            $this->badgeColor === 'red' => 'bg-red-500',
            $this->badgeColor === 'orange' => 'bg-orange-500',
            $this->badgeColor === 'amber' => 'bg-amber-500',
            $this->badgeColor === 'yellow' => 'bg-yellow-500',
            $this->badgeColor === 'lime' => 'bg-lime-500',
            $this->badgeColor === 'green' => 'bg-green-500',
            $this->badgeColor === 'emerald' => 'bg-emerald-500',
            $this->badgeColor === 'teal' => 'bg-teal-500',
            $this->badgeColor === 'cyan' => 'bg-cyan-500',
            $this->badgeColor === 'sky' => 'bg-sky-500',
            $this->badgeColor === 'blue' => 'bg-blue-500',
            $this->badgeColor === 'indigo' => 'bg-indigo-500',
            $this->badgeColor === 'violet' => 'bg-violet-500',
            $this->badgeColor === 'purple' => 'bg-purple-500',
            $this->badgeColor === 'fuchsia' => 'bg-fuchsia-500',
            $this->badgeColor === 'pink' => 'bg-pink-500',
            $this->badgeColor === 'rose' => 'bg-rose-500',
            default => 'bg-primary',
        };

        $sizeClasses = match (true) {
            $this->attributes->get('sm') => 'size-1.5',
            $this->attributes->get('md') => 'size-2.5',
            $this->attributes->get('lg') => 'size-3',
            $this->attributes->get('xl') => 'size-3.5',
            default => 'size-2.5',
        };

        return "absolute block {$sizeClasses} rounded-full {$badgeColors} ring-2";
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

    public function getBadgePosition(): string
    {
        $isSquare = $this->roundedClass() !== 'rounded-full';

        return match ($this->badgePosition) {
            'top' => $isSquare
            ? 'top-0 end-0 transform -translate-y-1/2 translate-x-1/2'
            : 'top-0 end-0',
            'bottom' => $isSquare
            ? 'bottom-0 end-0 transform translate-y-1/2 translate-x-1/2'
            : 'bottom-0 end-0',
            default => 'top-0 end-0',
        };
    }
}