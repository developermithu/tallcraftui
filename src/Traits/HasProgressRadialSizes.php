<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasProgressRadialSizes
{
    public function getSizeClasses(): array
    {
        $sizes = [
            'xs' => ['size' => 'h-16 w-16', 'text' => 'text-xs', 'stroke' => '3'],
            'sm' => ['size' => 'h-20 w-20', 'text' => 'text-sm', 'stroke' => '4'],
            'md' => ['size' => 'h-24 w-24', 'text' => 'text-base', 'stroke' => '5'],
            'lg' => ['size' => 'h-32 w-32', 'text' => 'text-lg', 'stroke' => '6'],
            'xl' => ['size' => 'h-40 w-40', 'text' => 'text-xl', 'stroke' => '8'],
            '2xl' => ['size' => 'h-48 w-48', 'text' => 'text-2xl', 'stroke' => '10'],
        ];

        // Check for size props (xs, sm, md, lg, xl, 2xl)
        foreach ($sizes as $size => $classes) {
            if ($this->attributes->has($size)) {
                return $classes;
            }
        }

        // Default to md if no size prop is found
        return $sizes['md'];
    }

    public function getStrokeWidth(): string
    {
        // Use custom stroke if provided, otherwise use size-based stroke
        return (string) ($this->stroke ?? $this->getSizeClasses()['stroke']);
    }
}
