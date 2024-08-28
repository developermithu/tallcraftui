<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\HeightHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Drawer extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $id = null,

        public bool $left = false,
        public bool $right = false,
        public bool $top = false,
        public bool $bottom = false,

        public bool $noSeparator = false,
        public bool $persistent = false,
        public bool $withoutDismissible = false,
        public bool $withoutTrapFocus = false,
    ) {}

    public function widthClass(): string
    {
        $widths = [
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            'full' => 'max-w-full',
        ];

        foreach ($widths as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultWidth = config('tallcraftui.drawer.width', 'lg');

        return $widths[$defaultWidth] ?? $widths['lg'];
    }

    public function heightClass(): string
    {
        return HeightHelper::getHeightClass('drawer', $this->attributes);
    }

    public function bgBlurClasses()
    {
        $isDefaultBlur = config('tallcraftui.drawer.blur', false);

        return match (true) {
            $this->attributes->get('blur') => 'backdrop-blur',
            $this->attributes->get('blur-sm') => 'backdrop-blur-sm',
            $this->attributes->get('blur-md') => 'backdrop-blur-md',
            $this->attributes->get('blur-lg') => 'backdrop-blur-lg',
            $this->attributes->get('blur-xl') => 'backdrop-blur-xl',
            $this->attributes->get('blur-2xl') => 'backdrop-blur-2xl',
            $this->attributes->get('blur-3xl') => 'backdrop-blur-3xl',
            $this->attributes->get('blur-none') => 'backdrop-blur-none',

            default => match ($isDefaultBlur) {
                true => 'backdrop-blur-sm',
                default => '',
            },
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $id = $id ?? md5($attributes->wire('model'));
            @endphp
            
            <div 
                x-data="{ open: @entangle($attributes->wire('model')) }" 
                @close.stop="open = false"
                @close.window="open = false"
                @close-modal.window="open = false"
                id="{{ $id }}"
                class="relative z-50 w-auto h-auto"
            >
                <template x-teleport="body">
                    <div 
                        x-show="open" 
                        
                        @if(!$persistent)
                            @keydown.window.escape="open = false"
                        @endif
                        
                        class="relative z-[99]"
                    >
                        <!-- Baground Overlay -->
                        <div 
                            x-show="open" 
                            x-transition.opacity.duration.300ms
                            
                            @if(!$persistent)
                                @click="open = false"
                            @endif
                            
                            @class(["fixed inset-0 bg-gray-700/80", $bgBlurClasses()])
                        >
                        </div>

                        <div class="fixed inset-0 overflow-hidden">
                            <div class="absolute inset-0 overflow-hidden">
                                <div 
                                    {{ $attributes->twMergeFor(
                                                'position', 
                                                'fixed flex max-w-full',
                                                $left ? 'left-0 inset-y-0' : '',
                                                $right ? 'right-0 inset-y-0' : '',
                                                $top ? 'top-0 inset-x-0' : '',
                                                $bottom ? 'bottom-0 inset-x-0' : '',
                                                !$left && !$right && !$top && !$bottom ? 'right-0 inset-y-0' : '',
                                            ) 
                                        }}
                                    >
                                    <div 
                                        x-show="open" 
                                        @if(config('tallcraftui.drawer.trap-focus', false) && !$withoutTrapFocus)
                                            x-trap.inert.noscroll="open"
                                        @endif
                                        
                                        @if(!$persistent)
                                            @click.away="open = false"
                                        @endif

                                        x-transition:enter="transform transition ease-in-out duration-300"
                                        x-transition:leave="transform transition ease-in-out duration-300"
                                        
                                        @if($left)
                                            x-transition:enter-start="-translate-x-full" 
                                            x-transition:enter-end="translate-x-0"
                                            x-transition:leave-start="translate-x-0" 
                                            x-transition:leave-end="-translate-x-full"

                                            @elseif($top)
                                                x-transition:enter-start="-translate-y-full" 
                                                x-transition:enter-end="translate-y-0"
                                                x-transition:leave-start="translate-y-0" 
                                                x-transition:leave-end="-translate-y-full"

                                            @elseif($bottom)
                                                x-transition:enter-start="translate-y-full" 
                                                x-transition:enter-end="translate-y-0"
                                                x-transition:leave-start="translate-y-0" 
                                                x-transition:leave-end="translate-y-full"

                                            @else
                                                x-transition:enter-start="translate-x-full" 
                                                x-transition:enter-end="translate-x-0"
                                                x-transition:leave-start="translate-x-0" 
                                                x-transition:leave-end="translate-x-full"
                                        @endif

                                        @class(['w-screen', $widthClass() => !$top && !$bottom])
                                    >
                                        <div @class([
                                                "flex flex-col py-5 h-full overflow-y-auto bg-white dark:bg-gray-800 border-l shadow-lg border-neutral-100/70 dark:border-gray-700", 
                                                $heightClass() => $top || $bottom 
                                            ])                                           
                                        > 
                                            @if($title || !$withoutDismissible)
                                                <div class="px-4 mb-4 sm:px-5">                                                
                                                    <div @class(["flex items-center justify-between gap-1.5 pb-1", '!justify-end' => !$title])>
                                                        @if($title)
                                                            <h2 class="text-xl font-semibold leading-6 text-gray-900 dark:text-white">{{ $title }}</h2>
                                                        @endif
                                                            
                                                        @if(!$withoutDismissible)
                                                            <x-tc-button @click="open = false" icon="x-mark" label="Close" outline red sm />
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!$noSeparator)
                                                <x-separator class="mb-4" />
                                            @endif

                                            <!-- Content -->
                                            <div class="relative flex-1 px-4 sm:px-5">
                                                {{ $slot }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        HTML;
    }
}
