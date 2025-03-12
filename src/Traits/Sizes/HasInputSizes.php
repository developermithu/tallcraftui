<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasInputSizes
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

        $defaultSize = config('tallcraftui.input.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }

    public function getAddonSizeClasses(): string
    {
        $sizes = [
            'xs' => 'px-1.5 py-1 text-xs',
            'sm' => 'px-2 py-1.5 text-xs',
            'md' => 'px-3 py-2 text-sm',
            'lg' => 'px-4 py-3 text-base',
            'xl' => 'px-5 py-4 text-lg',
            '2xl' => 'px-6 py-3.5 text-xl',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.input.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }
}