<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasProgressSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'xs' => 'h-1',
            'sm' => 'h-2',
            'md' => 'h-3',
            'lg' => 'h-4',
            'xl' => 'h-5',
            '2xl' => 'h-6',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.progress.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }
}
