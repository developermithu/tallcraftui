<?php

namespace Developermithu\Tallcraftui\Traits\Borders;

use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;

trait HasInputBorders
{
    public function getRoundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('input', $this->attributes);
    }

    public function getPrefixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-s-none',
            $this->attributes->get('rounded-xs') => 'rounded-s-sm',
            $this->attributes->get('rounded-md') => 'rounded-s-md',
            $this->attributes->get('rounded-lg') => 'rounded-s-lg',
            $this->attributes->get('rounded-xl') => 'rounded-s-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-s-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-s-3xl',
            $this->attributes->get('rounded-full') => 'rounded-s-full',
            default => 'rounded-s',
        };
    }

    public function getSuffixRoundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-e-none',
            $this->attributes->get('rounded-xs') => 'rounded-e-sm',
            $this->attributes->get('rounded-md') => 'rounded-e-md',
            $this->attributes->get('rounded-lg') => 'rounded-e-lg',
            $this->attributes->get('rounded-xl') => 'rounded-e-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-e-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-e-3xl',
            $this->attributes->get('rounded-full') => 'rounded-e-full',
            default => 'rounded-e',
        };
    }
}