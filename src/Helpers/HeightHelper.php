<?php

namespace Developermithu\Tallcraftui\Helpers;

use Illuminate\View\ComponentAttributeBag;

class HeightHelper
{
    public static function getHeightClass(string $componentName, ComponentAttributeBag $attributes): string
    {
        return match (true) {
            $attributes->get('h-20') => '!min-h-20',
            $attributes->get('h-24') => '!min-h-24',
            $attributes->get('h-28') => '!min-h-28',
            $attributes->get('h-32') => '!min-h-32',
            $attributes->get('h-36') => '!min-h-36',
            $attributes->get('h-40') => '!min-h-40',
            $attributes->get('h-44') => '!min-h-44',
            $attributes->get('h-48') => '!min-h-48',
            $attributes->get('h-52') => '!min-h-52',
            $attributes->get('h-56') => '!min-h-56',
            $attributes->get('h-60') => '!min-h-60',
            $attributes->get('h-64') => '!min-h-64',
            $attributes->get('h-72') => '!min-h-72',
            $attributes->get('h-80') => '!min-h-80',
            $attributes->get('h-96') => '!min-h-96',
            $attributes->get('h-full') => '!h-full',
            default => config("tallcraftui.{$componentName}.height", '!h-64'),
        };
    }
}
