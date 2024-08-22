<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Separator extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public bool $iconOutline = false,
    ) {}

    public function titleClass(): string
    {
        return $this->title ? 'mb-3' : '';
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <hr {{ $attributes->withoutTwMergeClasses()->twMerge([
                        "border-0 h-[1px] my-1 bg-gray-100 dark:bg-gray-700",
                        $titleClass(),
                    ]) 
                }} 
            />

            @if($title)
                <li {{ $attributes->twMergeFor("title", "flex items-center gap-x-2 text-xs px-4 pb-1 uppercase font-medium text-gray-400 dark:text-gray-500") }}>
                    @if($icon)
                        <x-tc-icon 
                            :name="$icon" 
                            :solid="$iconOutline ? false : true" 
                            {{ $attributes->twMergeFor('icon', 'size-4') }} 
                        />
                    @endif

                    {{ __($title) }}
                </li>
            @endif
        HTML;
    }
}
