<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\Colors\HasStatColors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Stat extends Component
{
    use HasStatColors;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public int|string|null $number = null,

        public bool|string $tooltip = false,
        public bool|string $increase = false,
        public bool|string $decrease = false,
    ) {
    }

    public function iconRightClass()
    {
        return $this->iconRight != null ? 'order-2' : '';
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('stat', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes
                        ->except($colorAttributes)
                        ->withoutTwMergeClasses()
                        ->twMerge([
                            "flex flex-col bg-white border shadow-xs dark:bg-gray-800",
                            $getColorClasses(),
                            $roundedClass(),
                        ]) 
                    }}
                >
                <div class="flex p-4 gap-x-4 md:p-5">
                    @if($icon || $iconRight)
                        <div {{ $attributes->twMergeFor(
                                'icon', 
                                "flex size-[46px] shrink-0 items-center text-gray-600 dark:text-gray-400 justify-center bg-gray-100 dark:bg-gray-700",
                                $getIconBgColor(),
                                $iconRightClass(),
                                $roundedClass(),
                            ) 
                        }}>
                            <x-tc-icon :name="$icon ?? $iconRight" class="size-5 shrink-0" />
                        </div>
                    @endif

                    <div @class(["grow", "order-1" => $iconRight])>
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-gray-400">{{ __($title) }}</p>
                            
                            @if($tooltip)
                                <div title="{{ is_string($tooltip) ? $tooltip : $title }}">
                                    <x-tc-icon name="question-mark-circle" class="text-gray-500 size-[18px] shrink-0 dark:text-gray-400" />
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center mt-1 gap-x-2">
                            <h3 class="text-xl font-medium text-gray-800 sm:text-2xl dark:text-gray-200">{{ __($number) }}</h3>
                            
                            @if($increase || $decrease)
                                <span @class([
                                        'inline-flex items-center gap-x-1 rounded-full px-2 py-0.5',
                                        'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' => $increase,
                                        'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' => $decrease,
                                    ])>
                                    <x-tc-icon :name="$decrease ? 'arrow-trending-down' : 'arrow-trending-up'" class="size-4" />
                                    
                                    @if(is_string($increase) || is_string($decrease))
                                        <span class="inline-block text-xs font-medium"> {{ is_string($increase) ? $increase : $decrease }} </span>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
