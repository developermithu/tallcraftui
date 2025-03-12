<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\ModalTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    use ModalTrait;

    public function __construct(
        public ?string $id = null,
        public bool $persistent = false,
        public bool $noTransition = false,
        public bool $dismissible = false,
        public bool $withoutTrapFocus = false,
    ) {}

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
                    "fixed inset-0 z-999999 px-4 py-14 overflow-y-auto jetstream-modal sm:px-0", 
                    $getModalPosition(),
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
                    <div @class(["absolute inset-0 bg-gray-700/80", $getBgBlurClasses()])></div>
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
                                $getSizeClasses(),
                                $getRoundedClasses(),
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
