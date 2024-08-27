<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $id = null,
        public bool $persistent = false,
        public bool $noTransition = false,
        public bool $dismissible = false,
        public bool $withoutTrapFocus = false,
    ) {}

    public function sizeClasses()
    {
        $sizes = [
            'sm' => 'w-full sm:max-w-sm',
            'md' => 'w-full sm:max-w-md',
            'lg' => 'w-full sm:max-w-lg',
            'xl' => 'w-full sm:max-w-xl',
            '2xl' => 'w-full sm:max-w-2xl',
            '3xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-3xl',
            '4xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-4xl',
            '5xl' => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-5xl',
            '6xl' => 'w-full sm:mx-6 md:mx-8 xl:mx-0 sm:max-w-6xl',
            '7xl' => 'w-full sm:mx-6 md:mx-8 2xl:mx-0 sm:max-w-7xl',
            'full' => 'fixed inset-0 w-screen h-screen',
        ];

        foreach ($sizes as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultSize = config('tallcraftui.modal.size', 'lg');

        return $sizes[$defaultSize] ?? $sizes['lg'];
    }

    public function bgBlurClasses()
    {
        $isDefaultBlur = config('tallcraftui.modal.blur', false);

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

    public function modalPosition()
    {
        $positions = [
            'top' => 'flex items-start justify-center h-screen',
            'bottom' => 'flex items-end justify-center h-screen',
            'left' => 'flex items-center justify-start w-screen h-screen !pl-10',
            'right' => 'flex items-center justify-end w-screen h-screen !pr-10',
            'center' => 'flex items-center justify-center w-screen h-screen',
        ];

        foreach ($positions as $key => $class) {
            if ($this->attributes->has($key)) {
                return $class;
            }
        }

        $defaultPosition = config('tallcraftui.modal.position', 'top');

        return $positions[$defaultPosition] ?? $positions['top'];
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('modal', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $id = $id ?? md5($attributes->wire('model'));
            @endphp

            <div
                x-data="{ show: @entangle($attributes->wire('model')) }"
                @close.stop="show = false"
                @close.window="show = false"
                @close-modal.window="show = false"
                
                @if(!$persistent)
                    @keydown.escape.window="show = false"
                @endif

                x-show="show"
                id="{{ $id }}"

                @class([
                    "fixed inset-0 z-[999999] px-4 py-14 overflow-y-auto jetstream-modal sm:px-0", 
                    $modalPosition(),
                ])
                
                style="display: none;"
            >
                <div 
                    x-show="show" 
                    class="fixed inset-0 transition-all transform"
                    
                    @if(!$persistent)
                        @click="show = false"
                    @endif
                    
                    @if(!$noTransition)
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    @endif 
                >
                    <div @class(["absolute inset-0 bg-gray-700/80", $bgBlurClasses()])></div>
                </div>

                <div 
                    x-show="show" 
                    
                    @if(config('tallcraftui.modal.trap-focus', false) && !$withoutTrapFocus)
                        x-trap.inert.noscroll="show"
                    @endif
                    
                    @if(!$noTransition)
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @endif 
                    
                    {{ 
                        $attributes
                            ->except('wire:model')
                            ->twMerge([
                                "overflow-hidden transition-all transform p-4 md:p-5 bg-white dark:bg-gray-900 shadow-xl",
                                $sizeClasses(),
                                $roundedClass(),
                            ]) 
                    }}
                >
                    {{ $slot }}

                    @if($dismissible)
                        <div class="absolute top-2.5 right-3">
                            <x-tc-button @click="$dispatch('close')" icon="x-mark" red flat circle />
                        </div>
                    @endif
                </div>
            </div>
        HTML;
    }
}
