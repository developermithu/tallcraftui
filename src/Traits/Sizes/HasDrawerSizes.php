<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

use Developermithu\Tallcraftui\Helpers\HeightHelper;

trait HasDrawerSizes
{
    public function heightClass(): string
    {
        return HeightHelper::getHeightClass('drawer', $this->attributes);
    }

    public function getSizeClasses(): string
    {
        $widths = [
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            'full' => 'max-w-full',
        ];

        foreach ($widths as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultWidth = config('tallcraftui.drawer.width', 'lg');

        return $widths[$defaultWidth] ?? $widths['lg'];
    }
}