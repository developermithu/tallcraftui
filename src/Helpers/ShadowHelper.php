<?php

namespace Developermithu\Tallcraftui\Helpers;

use Illuminate\View\ComponentAttributeBag;

class ShadowHelper
{
    public static function getShadowClass(string $componentName, ComponentAttributeBag $attributes): string
    {
        return match (true) {
            $attributes->get('shadow') => 'shadow',
            $attributes->get('shadow-sm') => 'shadow-sm',
            $attributes->get('shadow-md') => 'shadow-md',
            $attributes->get('shadow-lg') => 'shadow-lg',
            $attributes->get('shadow-xl') => 'shadow-xl',
            $attributes->get('shadow-2xl') => 'shadow-2xl',
            $attributes->get('shadow-none') => 'shadow-none',
            default => config("tallcraftui.{$componentName}.shadow", 'shadow-md'),
        };
    }
}
