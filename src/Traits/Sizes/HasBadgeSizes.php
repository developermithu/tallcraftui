<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasBadgeSizes
{
    public function getSizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'text-xs px-1.5',
            $this->attributes->get('md') => 'text-xs px-2 py-0.5',
            $this->attributes->get('lg') => 'text-sm px-2.5 py-1',
            $this->attributes->get('xl') => 'text-base px-3 py-1.5',
            $this->attributes->get('2xl') => 'text-lg px-3.5 py-2',
            default => 'text-xs px-2 py-0.5',
        };
    }

    public function getIconSize(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'size-3',
            $this->attributes->get('md') => 'size-3',
            $this->attributes->get('lg') => 'size-3.5',
            $this->attributes->get('xl') => 'size-4',
            $this->attributes->get('2xl') => 'size-[18px]',
            default => 'size-3',
        };
    }
}
