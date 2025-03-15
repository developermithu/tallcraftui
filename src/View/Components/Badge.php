<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\Colors\HasBadgeColors;
use Developermithu\Tallcraftui\Traits\Sizes\HasBadgeSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    use HasBadgeSizes, HasBadgeColors;

    public function __construct(
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,

        // Badge Default Type
        public bool $primary = true,
    ) {
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('badge', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <span {{ $attributes
                        ->withoutTwMergeClasses()
                        ->except($colorAttributes)
                        ->twMerge([
                            "inline-flex gap-x-1 w-fit items-center justify-center font-semibold",
                            $getSizeClasses(), 
                            $getColorClasses(), 
                            $getOutlineClasses(),
                            $roundedClass(),
                        ]) 
                    }}
                >
                @if($icon)
                    <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', $getIconSize()) }} />
                @elseif ($iconLeft)
                    <x-tc-icon :name="$iconLeft" {{ $attributes->twMergeFor('icon', $getIconSize()) }} />
                @endif

                {{ $label ? __($label) : $slot }}

                @if($iconRight)
                    <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', $getIconSize()) }} />
                @endif
            </span>
        HTML;
    }
}
