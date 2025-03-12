<?php

namespace Developermithu\Tallcraftui\Traits;

trait HasDropdownPosition
{
    public function position(): string
    {
        $defaultPosition = config('tallcraftui.dropdown.position', 'bottom-end');

        $basePosition = match (true) {
            $this->attributes->get('top') => 'top',
            $this->attributes->get('top-start') => 'top-start',
            $this->attributes->get('top-end') => 'top-end',
            $this->attributes->get('bottom') => 'bottom',
            $this->attributes->get('bottom-start') => 'bottom-start',
            $this->attributes->get('bottom-end') => 'bottom-end',
            $this->attributes->get('left') => 'left',
            $this->attributes->get('left-start') => 'left-start',
            $this->attributes->get('left-end') => 'left-end',
            $this->attributes->get('right') => 'right',
            $this->attributes->get('right-start') => 'right-start',
            $this->attributes->get('right-end') => 'right-end',
            default => $defaultPosition,
        };

        return match ($basePosition) {
            'top' => 'x-anchor.top.offset.14',
            'top-start' => 'x-anchor.top-start.offset.14',
            'top-end' => 'x-anchor.top-end.offset.14',
            'bottom' => 'x-anchor.bottom.offset.14',
            'bottom-start' => 'x-anchor.bottom-start.offset.14',
            'bottom-end' => 'x-anchor.bottom-end.offset.14',
            'left' => 'x-anchor.left.offset.14',
            'left-start' => 'x-anchor.left-start.offset.14',
            'left-end' => 'x-anchor.left-end.offset.14',
            'right' => 'x-anchor.right.offset.14',
            'right-start' => 'x-anchor.right-start.offset.14',
            'right-end' => 'x-anchor.right-end.offset.14',
            default => 'x-anchor.bottom-end.offset.14',
        };
    }
}