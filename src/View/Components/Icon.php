<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(
        public string $name = 'face-smile',
        public bool $solid = false,
    ) {}

    public function name()
    {
        $configStyle = config('tallcraftui.icons.style', 'outline');
        $defaultStyle = $configStyle === 'solid' ? 's' : 'o';

        $iconFormat = $this->solid ? 's' : $defaultStyle;

        return "heroicon-$iconFormat-$this->name";
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <x-dynamic-component :component="$name()" {{ $attributes->twMerge(['w-5 h-5']) }} />
        HTML;
    }
}
