<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasRatingSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'sm' => 'size-4',
            'md' => 'size-5',
            'lg' => 'size-6',
            'xl' => 'size-7',
            '2xl' => 'size-8',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.rating.size', 'lg');

        return $sizes[$defaultSize] ?? $sizes['lg'];
    }
}