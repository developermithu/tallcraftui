<?php

namespace Developermithu\Tallcraftui\Helpers;

use Illuminate\View\ComponentAttributeBag;

class WidthHelper
{
    public static function getWidthClass(string $componentName, ComponentAttributeBag $attributes): string
    {
        return match (true) {
            $attributes->get('w-20') => 'w-20',
            $attributes->get('w-24') => 'w-24',
            $attributes->get('w-28') => 'w-28',
            $attributes->get('w-32') => 'w-32',
            $attributes->get('w-36') => 'w-36',
            $attributes->get('w-40') => 'w-40',
            $attributes->get('w-44') => 'w-44',
            $attributes->get('w-48') => 'w-48',
            $attributes->get('w-52') => 'w-52',
            $attributes->get('w-56') => 'w-56',
            $attributes->get('w-60') => 'w-60',
            $attributes->get('w-64') => 'w-64',
            $attributes->get('w-72') => 'w-72',
            $attributes->get('w-80') => 'w-80',
            $attributes->get('w-96') => 'w-96',
            $attributes->get('w-full') => 'w-full',
            default => config("tallcraftui.{$componentName}.width", 'w-48'),
        };
    }
}
