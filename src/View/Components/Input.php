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
        public ?string $iconClass = 'size-4',
        public ?string $hint = null,
        public ?string $preffix = null,
        public ?string $suffix = null,
        public ?bool $inline = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div 
                @class([
                    '',
                    'inline-flex items-center gap-3' => $inline 
                ])
            >
                @if($label)
                    <label for="UserEmail"
                        @class([
                            "text-sm font-medium text-gray-700",
                            "block mb-1.5" => !$inline    
                        ])
                    >     
                        {{ $label }} 
                    </label>
                 @endif

                <div class="relative flex items-center flex-1">
                    @if($iconLeft)
                        <span class="absolute inset-y-0 grid w-10 start-0 place-content-center">
                            <x-icon :name="$iconLeft" :class="$iconClass" />
                        </span>
                    @endif
                
                    <input
                        type="text"
                        id="Search"
                        placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                        @class([
                            "w-full rounded-md border-gray-200 py-2.5 pe-10 shadow-sm sm:text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white",
                            "pl-9" => $iconLeft !== null 
                            ]) 
                        />

                        @if($iconRight || $icon)
                            <span class="absolute inset-y-0 grid w-10 end-0 place-content-center">
                                <x-icon :name="$iconRight ?? $icon" :class="$iconClass" />
                            </span>
                        @endif
                </div>
            </div>
        HTML;
    }
}
