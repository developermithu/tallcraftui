<?php

namespace Developermithu\Tallcraftui\Traits;

use Developermithu\Tallcraftui\Helpers\ShadowHelper;

trait CardTrait
{
    public function getRoundedClass(): string
    {
        $default = config('tallcraftui.card.border-radius', 'rounded-lg');

        return match (true) {
            $default === 'rounded-sm' => 'rounded-sm',
            $default === 'rounded-xs' => 'rounded-xs',
            $default === 'rounded-md' => 'rounded-md',
            $default === 'rounded-lg' => 'rounded-lg',
            $default === 'rounded-xl' => 'rounded-xl',
            $default === 'rounded-2xl' => 'rounded-2xl',
            $default === 'rounded-3xl' => 'rounded-3xl',
            $default === 'rounded-full' => 'rounded-full',
            $default === 'rounded-none' => 'rounded-none',
            default => 'rounded-lg',
        };
    }

    public function shadowClass(): string
    {
        return ShadowHelper::getShadowClass('card', $this->attributes);
    }
}