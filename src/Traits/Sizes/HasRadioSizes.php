<?php

namespace Developermithu\Tallcraftui\Traits\Sizes;

trait HasRadioSizes
{
    public function getSizeClasses(): string
    {
        $sizes = [
            'sm' => 'size-4',
            'md' => 'size-[18px]',
            'lg' => 'size-6',
            'xl' => 'size-7',
            '2xl' => 'size-8',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.radio.size', 'md');

        return $sizes[$defaultSize] ?? $sizes['md'];
    }
}