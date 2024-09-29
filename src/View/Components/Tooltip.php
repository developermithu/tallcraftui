<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tooltip extends Component
{
    public function __construct(
        public string $text,
        public ?string $icon = null,
        public ?bool $gradient = null,
        public ?bool $noArrow = null,
        public ?bool $noTransition = null
    ) {
        $this->gradient = $gradient ?? config('tallcraftui.tooltip.gradient', false);
        $this->noArrow = $noArrow ?? config('tallcraftui.tooltip.noArrow', false);
        $this->noTransition = $noTransition ?? config('tallcraftui.tooltip.noTransition', false);
    }

    public function position(): string
    {
        return match (true) {
            $this->attributes->get('top') => 'top',
            $this->attributes->get('bottom') => 'bottom',
            $this->attributes->get('left') => 'left',
            $this->attributes->get('right') => 'right',
            default => config('tallcraftui.tooltip.position', 'top'),
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div
                x-data="{
                    tooltipVisible: false,
                    tooltipText: '{{ $text }}',
                    tooltipArrow: {{ $noArrow ? 'false' : 'true' }},
                }"
                x-init="
                    $refs.content.addEventListener('mouseenter', () => { tooltipVisible = true; }); 
                    $refs.content.addEventListener('mouseleave', () => { tooltipVisible = false; });
                "
                class="relative"
            >
                <div 
                    x-cloak
                    x-ref="tooltip" 
                    x-show="tooltipVisible" 
                    @class([
                        'absolute z-50 w-auto text-sm',   
                        '-top-0.5 left-1/2 -translate-x-1/2 -mt-0.5 -translate-y-full' => $position() === 'top',
                        '-bottom-0.5 left-1/2 -translate-x-1/2 -mb-0.5 translate-y-full' => $position() === 'bottom',
                        'top-1/2 -translate-y-1/2 -ml-0.5 -left-0.5 -translate-x-full' => $position() === 'left',
                        'top-1/2 -translate-y-1/2 -mr-0.5 -right-0.5 translate-x-full' => $position() === 'right' 
                    ])
                >
                    <div 
                        x-show="tooltipVisible"
                        @if(!$noTransition)
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90"
                        @endif
                        @class([
                            'relative z-50 px-2.5 py-1.5 text-white rounded dark:bg-gray-700 bg-gray-900 font-medium',
                            'bg-gradient-to-t from-blue-600 to-purple-600 bg-opacity-90' => $gradient
                        ])
                    >
                        <p x-text="tooltipText" 
                            {{ $attributes
                                ->withoutTwMergeClasses()
                                ->except(['top', 'bottom', 'left', 'right'])
                                ->twMerge(['flex-shrink-0 block text-xs whitespace-nowrap'])
                            }}
                        ></p>
                        <div 
                            x-ref="tooltipArrow" 
                            x-show="tooltipArrow"
                            @class([
                                'absolute inline-flex items-center justify-center overflow-hidden',   
                                'bottom-0 -translate-x-1/2 left-1/2 w-2.5 translate-y-full' => $position() === 'top',
                                'top-0 -translate-x-1/2 left-1/2 w-2.5 -translate-y-full' => $position() === 'bottom',
                                'right-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px translate-x-full' => $position() === 'left',
                                'left-0 -translate-y-1/2 top-1/2 h-2.5 -mt-px -translate-x-full' => $position() === 'right'
                            ])
                        >
                            <div
                                @class([
                                    'w-1.5 h-1.5 transform dark:bg-gray-700 bg-gray-900',
                                    '!bg-indigo-600 bg-opacity-90' => $gradient,
                                    'origin-top-left -rotate-45' => $position() === 'top',
                                    'origin-bottom-left rotate-45' => $position() === 'bottom',
                                    'origin-top-left rotate-45' => $position() === 'left',
                                    'origin-top-right -rotate-45' => $position() === 'right'
                                ])
                            ></div>
                        </div>
                    </div>
                </div>
                
                <div x-ref="content" {{ $attributes->twMergeFor('content') }}>
                    @if ($slot->isEmpty())
                        <x-tc-icon :name="$icon ?? 'question-mark-circle'" class="text-gray-500 dark:text-gray-400" />
                    @else
                        {{ $slot }}
                    @endif
                </div>
            </div>
        HTML;
    }
}
