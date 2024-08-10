<?php

namespace Developermithu\Tallcraftui\Helpers;

use Illuminate\View\ComponentAttributeBag;

class BorderRadiusHelper
{
    public static function getRoundedClass(string $componentName, ComponentAttributeBag $attributes): string
    {
        return match (true) {
            $attributes->get('rounded') => 'rounded',
            $attributes->get('rounded-sm') => 'rounded-sm',
            $attributes->get('rounded-md') => 'rounded-md',
            $attributes->get('rounded-lg') => 'rounded-lg',
            $attributes->get('rounded-xl') => 'rounded-xl',
            $attributes->get('rounded-2xl') => 'rounded-2xl',
            $attributes->get('rounded-3xl') => 'rounded-3xl',
            $attributes->get('rounded-full') => 'rounded-full',
            $attributes->get('rounded-none') => 'rounded-none',
            default => config("tallcraftui.{$componentName}.border-radius", 'rounded'),
        };
    }
}
