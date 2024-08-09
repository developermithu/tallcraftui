<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BreadcrumbItem extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $href = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public bool $iconNone = false,
    ) {}

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <li>
                <div class="flex items-center gap-1 md:gap-2">
                    @if($icon)
                        <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', 'text-gray-400 size-6') }} />
                    @endif
                    
                    @if(!$icon && !$iconNone) 
                        <x-tc-icon name="chevron-right" {{ $attributes->twMergeFor('icon', 'text-gray-400 size-6') }} />
                    @endif

                    @isset($iconLeft)
                        <x-tc-icon :name="$iconLeft" {{ $attributes->twMergeFor('icon', 'text-gray-400 size-6') }} />
                    @endisset
                
                    @isset($href)
                        <a wire:navigate href="{{ $href }}"
                            {{ $attributes->withoutTwMergeClasses()
                                ->twMerge(["text-gray-400 capitalize hover:text-gray-500 dark:text-gray-100 dark:hover:text-gray-400"]) 
                            }}
                        >
                            {{ __($label) }}
                        </a>
                    @else
                        <span {{ $attributes->withoutTwMergeClasses()->twMerge(["text-gray-500 capitalize dark:text-gray-400"]) }}>
                            {{ __($label) }}
                        </span>
                    @endisset

                    @isset($iconRight)
                        <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', 'text-gray-400 size-6') }} />
                    @endisset
                </div>
            </li>
        HTML;
    }
}
