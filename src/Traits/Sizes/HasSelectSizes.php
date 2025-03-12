<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasSelectSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'xs' => 'py-1 text-xs',
            'sm' => 'py-1.5 text-xs',
            'md' => 'py-2 text-sm',
            'lg' => 'py-2.5 text-base',
            'xl' => 'py-3 text-lg',
            '2xl' => 'py-3.5 text-xl',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.select.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }
}