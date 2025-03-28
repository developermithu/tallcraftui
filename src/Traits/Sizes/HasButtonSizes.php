<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasButtonSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'xs' => 'px-2.5 py-1 text-xs',
            'sm' => 'px-3 py-1.5 text-xs',
            'md' => 'px-4 py-2 text-xs',
            'lg' => 'px-5 py-2.5 text-sm',
            'xl' => 'px-6 py-3 text-base',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.button.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function getCircleClasses(): string
    {
        $circleWithoutLabel = $this->attributes->get('circle') && !$this->label;

        return match (true) {
            $circleWithoutLabel && $this->attributes->get('xs') => 'rounded-full w-7 h-7 p-1.5 justify-center',
            $circleWithoutLabel && $this->attributes->get('sm') => 'rounded-full w-8 h-8 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('md') => 'rounded-full w-10 h-10 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('lg') => 'rounded-full w-12 h-12 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('xl') => 'rounded-full w-14 h-14 p-2 justify-center',
            $circleWithoutLabel => 'rounded-full w-10 h-10 p-2 justify-center', // md
            default => '',
        };
    }

    public function getIconSize(): string
    {
        return match (true) {
            $this->attributes->get('xs') => 'size-4',
            $this->attributes->get('sm') => 'size-4',
            $this->attributes->get('md') => 'size-4.5',
            $this->attributes->get('lg') => 'size-5',
            $this->attributes->get('xl') => 'size-5.5',
            default => 'size-4.5',
        };
    }
}
