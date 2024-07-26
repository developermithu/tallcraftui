<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $id = null,
        public bool $persistent = false,
    ) {}

    public function sizeClasses()
    {
        return match (true) {
            $this->attributes->get('sm') => 'w-full sm:max-w-sm',
            $this->attributes->get('md') => 'w-full sm:max-w-md',
            $this->attributes->get('lg') => 'w-full sm:max-w-lg',
            $this->attributes->get('xl') => 'w-full sm:max-w-xl',
            $this->attributes->get('3xl') => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-3xl',
            $this->attributes->get('4xl') => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-4xl',
            $this->attributes->get('5xl') => 'w-full sm:mx-6 md:mx-8 lg:mx-0 sm:max-w-5xl',
            $this->attributes->get('6xl') => 'w-full sm:mx-6 md:mx-8 xl:mx-0 sm:max-w-6xl',
            $this->attributes->get('7xl') => 'w-full sm:mx-6 md:mx-8 2xl:mx-0 sm:max-w-7xl',
            $this->attributes->get('full') => 'w-full mx-4 sm:mx-6 md:mx-8 lg:mx-14 xl:mx-20 sm:max-w-full',
            default => 'w-full sm:max-w-2xl', // default 2xl
        };
    }

    public function bgBlurClasses()
    {
        return match (true) {
            $this->attributes->get('blur') => 'backdrop-blur',
            $this->attributes->get('blur-sm') => 'backdrop-blur-sm',
            $this->attributes->get('blur-md') => 'backdrop-blur-md',
            $this->attributes->get('blur-lg') => 'backdrop-blur-lg',
            $this->attributes->get('blur-xl') => 'backdrop-blur-xl',
            $this->attributes->get('blur-2xl') => 'backdrop-blur-2xl',
            $this->attributes->get('blur-3xl') => 'backdrop-blur-3xl',
            default => '',
        };
    }

    public function modalPosition()
    {
        return match (true) {
            $this->attributes->get('center') => 'flex items-center h-screen justify-center',
            $this->attributes->get('bottom') => 'flex items-end h-screen justify-center',
            $this->attributes->get('left') => 'flex items-center w-screen h-screen justify-start !pl-10',
            $this->attributes->get('right') => 'flex items-center w-screen h-screen justify-end !pr-10',
            default => 'flex items-start h-screen justify-center', // default top
        };
    }

    public function roundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-none',
            $this->attributes->get('rounded-sm') => 'rounded-sm',
            $this->attributes->get('rounded-md') => 'rounded-md',
            $this->attributes->get('rounded-xl') => 'rounded-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-3xl',
            $this->attributes->get('rounded-full') => 'rounded-full',
            default => 'rounded-lg',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $id = $id ?? md5($attributes->wire('model'));
            @endphp

            <div
                x-data="{ show: @entangle($attributes->wire('model')) }"
                x-on:close.stop="show = false"
                
                @if(!$persistent)
                    x-on:keydown.escape.window="show = false"
                @endif

                x-show="show"
                id="{{ $id }}"

                @class([
                    "fixed inset-0 z-50 px-4 py-14 overflow-y-auto jetstream-modal sm:px-0", $modalPosition()
                ])
                
                style="display: none;"
            >
                <div 
                    x-show="show" 
                    class="fixed inset-0 transition-all transform"
                    
                    @if(!$persistent)
                        x-on:click="show = false"
                    @endif
                
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div 
                        @class([
                            "absolute inset-0 bg-gray-700/80",
                            $bgBlurClasses(),
                        ])
                    ></div>
                </div>

                <div 
                    x-show="show" 
                    x-trap.inert.noscroll="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    {{ 
                        $attributes
                            ->except('wire:model')
                            ->class([
                                "overflow-hidden transition-all transform bg-white dark:bg-gray-800 shadow-xl",
                                $sizeClasses(),
                                $roundClasses(),
                            ]) 
                    }}
                >
                    {{ $slot }}
                </div>
            </div>
        HTML;
    }
}
