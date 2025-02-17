<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasButtonSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'sm' => 'px-3 py-1.5 text-xs',
            'md' => 'px-4 py-2 text-sm',
            'lg' => 'px-5 py-2.5 text-base',
            'xl' => 'px-6 py-3 text-lg',
            '2xl' => 'px-7 py-3.5 text-xl',
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
            $circleWithoutLabel && $this->attributes->get('sm') => 'rounded-full w-8 h-8 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('md') => 'rounded-full w-10 h-10 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('lg') => 'rounded-full w-12 h-12 p-2 justify-center',
            $circleWithoutLabel && $this->attributes->get('xl') => 'rounded-full w-14 h-14 p-2 justify-center',
            $circleWithoutLabel => 'rounded-full w-10 h-10 p-2 justify-center', // md
            default => '',
        };
    }

    public function getCircleIconSize(): string
    {
        $circleWithoutLabel = $this->attributes->get('circle') && !$this->label;

        return match (true) {
            $circleWithoutLabel && $this->attributes->get('sm') => 'size-4',
            $circleWithoutLabel && $this->attributes->get('md') => 'size-5',
            $circleWithoutLabel && $this->attributes->get('lg') => 'size-6',
            $circleWithoutLabel && $this->attributes->get('xl') => 'size-7',
            default => 'size-5',
        };
    }
}
