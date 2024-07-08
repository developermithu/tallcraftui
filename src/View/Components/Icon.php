<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Icon extends Component
{
    public function __construct(
        public string $name = 'face-smile',
        public ?string $class = null,
        public bool $solid = false,
    ) {
    }

    public function name()
    {
        $configStyle = config('tallcraftui.icons.style');
        $defaultStyle = $configStyle === 'solid' ? 's' : 'o';

        $iconFormat = $this->solid ? 's' : $defaultStyle;
        return "heroicon-$iconFormat-$this->name";
    }

    public function class()
    {
        return 'w-5 h-5 ' . $this->class;
    }


    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                @svg($name(), $class())
            </div>
        HTML;
    }
}
