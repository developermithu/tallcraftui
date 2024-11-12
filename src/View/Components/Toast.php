<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Toast extends Component
{
    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                @persist('tallcraftui-toaster')
                    <div
                        x-cloak
                        x-data="{ show: false, timer: null, toast: null }"
                        @tallcraftui-toast.window="
                            clearTimeout(timer);
                            toast = $event.detail.toast;
                            show = true;
                            if (toast.timeout > 0) {
                                timer = setTimeout(() => show = false, toast.timeout);
                            }
                        "
                    >
                        <div
                            x-show="show"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            :class="[ 
                                getPositionClasses(toast?.position),
                                getAnimationClasses(toast?.position),
                            ]"
                            :style="getPositionStyle(toast?.position)"
                            
                            {{ $attributes
                                ->withoutTwMergeClasses()
                                ->twMerge([
                                    'fixed z-50 bg-white max-w-md dark:bg-gray-800 dark:border-gray-700 flex items-center p-4 mb-4 rounded-lg shadow border border-gray-200',
                                ]) 
                            }}
                        >
                            <!-- Progress Bar -->
                            <template x-if="toast?.showProgress">
                                <div
                                    x-show="toast?.timeout > 0"
                                    class="absolute bottom-0 left-0 h-1 transition-transform origin-left rounded-lg"
                                    :class="getProgressBarColor(toast?.type)"
                                    :style="getProgressBarStyle(toast?.timeout)"
                                ></div>
                            </template>

                            <div class="flex items-center justify-between w-full" :class="{ '!items-start' : toast?.description }">
                                <div class="flex items-center" :class="{ '!items-start' : toast?.description }">
                                    <div x-html="toast?.icon" class="mr-2"></div>
                                    <div>
                                        <h3 x-text="toast?.title" 
                                            {{ $attributes->twMergeFor('title', 'text-base font-medium text-gray-900 dark:text-white') }}></h3>
                                        <p x-text="toast?.description" 
                                            {{ $attributes->twMergeFor('description', 'text-sm text-gray-500 dark:text-gray-400') }}></p>
                                    </div>
                                </div>
                                
                                <template x-if="toast?.showCloseIcon">
                                    <button @click="show = false" {{ $attributes->twMergeFor('close-icon', 'ml-4 text-current opacity-50 hover:opacity-100') }}>
                                        <x-tc-icon name="x-mark" class="size-5" />
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <script>
                        function getPositionStyle(position) {
                            const styles = {
                                'top-left': { top: '1rem', left: '1rem' },
                                'top-right': { top: '1rem', right: '1rem' },
                                'bottom-left': { bottom: '1rem', left: '1rem' },
                                'bottom-right': { bottom: '1rem', right: '1rem' }
                            };
                            return styles[position] || { top: '1rem', right: '1rem' };
                        }

                        function getPositionClasses(position) {
                            const classes = {
                                'top-left': 'origin-top-left',
                                'top-right': 'origin-top-right',
                                'bottom-left': 'origin-bottom-left',
                                'bottom-right': 'origin-bottom-right'
                            };
                            return classes[position] || 'origin-top-right';
                        }

                        function getAnimationClasses(position) {
                            return position && position.startsWith('bottom') 
                                ? 'animate-slide-in-bottom' 
                                : 'animate-slide-in-top';
                        }

                        function getProgressBarColor(type) {
                            const colors = {
                                'success': 'bg-green-500',
                                'error': 'bg-red-500',
                                'warning': 'bg-yellow-500',
                                'info': 'bg-blue-500'
                            };
                            return colors[type] || 'bg-green-500';
                        }

                        
                        function getProgressBarStyle(timeout) {
                            if (!timeout) return '';
                            return {
                                width: '100%',
                                transform: 'scaleX(1)',
                                animation: `progress ${timeout}ms linear forwards`
                            };
                        }
                        
                        window.toast = function(payload) {
                            window.dispatchEvent(new CustomEvent('tallcraftui-toast', {detail: payload}));
                        }
                        
                        document.addEventListener('livewire:initialized', () => {
                            Livewire.hook('request', ({fail}) => {
                                fail(({status, content, preventDefault}) => {
                                    try {
                                        let result = JSON.parse(content);
                                        if (result?.toast && typeof window.toast === "function") {
                                            window.toast(result);
                                        }
                                        if ((result?.prevent_default ?? false) === true) {
                                            preventDefault();
                                        }
                                    } catch (e) {
                                        console.error(e);
                                    }
                                });
                            });
                        });
                    </script>

                    <style>
                        @keyframes slideInTop {
                            from { transform: translateY(-100%); }
                            to { transform: translateY(0); }
                        }
                        @keyframes slideInBottom {
                            from { transform: translateY(100%); }
                            to { transform: translateY(0); }
                        }
                        @keyframes progress {
                            from { transform: scaleX(1); }
                            to { transform: scaleX(0); }
                        }
                        .animate-slide-in-top { animation: slideInTop 0.3s ease-out; }
                        .animate-slide-in-bottom { animation: slideInBottom 0.3s ease-out; }
                    </style>
                @endpersist
            </div>
        HTML;
    }
}
