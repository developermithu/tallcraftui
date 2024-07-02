<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $preffix = null,
        public ?string $suffix = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                <div>
                    
                 @if($label)
                    <label for="UserEmail" class="block text-xs font-medium text-gray-700">     
                        {{ $label }} 
                    </label>
                 @endif

                <input
                    type="email"
                    id="UserEmail"
                    placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                    class="w-full mt-1 border-gray-200 rounded-md shadow-sm sm:text-sm"
                />
                </div>
            </div>
        HTML;
    }
}
