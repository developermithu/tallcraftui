<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        // Button content
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,
        public ?string $iconClass = 'size-4',

        // Button colors
        public bool $primary = true,
        public bool $secondary = false,
        public bool $warning = false,
        public bool $info = false,
        public bool $success = false,
        public bool $danger = false,

        // Button styles
        public bool $outline = false,
        public bool $flat = false,
        public bool $circle = false,
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <button 
                @php 
                    $sm = $attributes->get('sm');
                    $lg = $attributes->get('lg');
                    $xl = $attributes->get('xl');
                    $xxl = $attributes->get('xxl');
                    $md = $attributes->get('md') || (!$sm && !$lg && !$xl && !$xxl);
                @endphp

                {{ $attributes
                    ->merge(['type' => 'submit'])
                    ->class([
                        "inline-flex gap-x-1.5 items-center dark:bg-gray-200 border border-transparent rounded font-semibold text-xs text-gray-600 uppercase tracking-widest dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150",
                        
                        "bg-violet-600 text-white hover:bg-violet-700 focus:bg-violet-700 focus:ring-violet-500 active:bg-violet-800" => $primary && !$flat && !$outline && !$secondary && !$danger && !$warning && !$info && !$success,
                        "bg-gray-200 hover:bg-gray-300 focus:ring-gray-500" => $secondary && !$flat && !$outline,
                        "bg-yellow-600 text-white hover:bg-yellow-700 focus:bg-yellow-700 focus:ring-yellow-500 active:bg-yellow-800" => $warning && !$flat && !$outline,
                        "bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 focus:ring-red-500 active:bg-red-800" => $danger && !$flat && !$outline,
                        "bg-green-600 text-white hover:bg-green-700 focus:bg-green-700 focus:ring-green-500 active:bg-green-800" => $success && !$flat && !$outline,
                        "bg-blue-600 text-white hover:bg-blue-700 focus:bg-blue-700 focus:ring-blue-500 active:bg-blue-800" => $info && !$flat && !$outline,

                        "!bg-transparent" => $outline,
                        "!border-violet-300 text-violet-600 hover:bg-violet-100 focus:bg-violet-100 active:bg-violet-100 focus:ring-violet-500" => ($outline && $primary) && !$secondary && !$danger && !$warning && !$info && !$success,
                        "!border-gray-300 text-gray-600 hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 focus:ring-gray-500" => $outline && $secondary,
                        "!border-yellow-300 text-yellow-600 hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-100 focus:ring-yellow-500" => $outline && $warning,
                        "!border-green-300 text-green-600 hover:bg-green-100 focus:bg-green-100 active:bg-green-100 focus:ring-green-500" => $outline && $success,
                        "!border-red-300 text-red-600 hover:bg-red-100 focus:bg-red-100 active:bg-red-100 focus:ring-red-500" => $outline && $danger,
                        "!border-blue-300 text-blue-600 hover:bg-blue-100 focus:bg-blue-100 active:bg-blue-100 focus:ring-blue-500" => $outline && $info,

                        "!bg-transparent" => $flat,
                        "text-violet-600 hover:bg-violet-100 focus:bg-violet-100 active:bg-violet-100 focus:ring-violet-500" => ($flat && $primary) && !$secondary && !$danger && !$warning && !$info && !$success,
                        "text-gray-600 hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-100 focus:ring-gray-500" => $flat && $secondary,
                        "text-yellow-600 hover:bg-yellow-100 focus:bg-yellow-100 active:bg-yellow-100 focus:ring-yellow-500" => $flat && $warning,
                        "text-green-600 hover:bg-green-100 focus:bg-green-100 active:bg-green-100 focus:ring-green-500" => $flat && $success,
                        "text-red-600 hover:bg-red-100 focus:bg-red-100 active:bg-red-100 focus:ring-red-500" => $flat && $danger,
                        "text-blue-600 hover:bg-blue-100 focus:bg-blue-100 active:bg-blue-100 focus:ring-blue-500" => $flat && $info,

                        "px-3 py-1.5" => $sm,
                        "px-4 py-2" => $md,
                        "px-5 py-2.5" => $lg,
                        "px-6 py-3" => $xl,
                        "px-7 py-3.5" => $xxl,

                        "rounded-full" => $circle,
                        "rounded-full w-10 h-10 justify-center" => $circle && !$label,
                        "rounded-full w-8 h-8 justify-center" => $circle && $sm && !$label,
                        "rounded-full w-12 h-12 justify-center" => $circle && $lg && !$label,
                        "rounded-full w-14 h-14 justify-center" => $circle && $xl && !$label,
                    ])
                }}
            >
                @if($icon)
                    <x-icon :name="$icon" :class="$iconClass" />
                @elseif ($iconLeft)
                    <x-icon :name="$iconLeft" :class="$iconClass" />
                @endif

                {{ $label ? __($label) : '' }}

                {{ $slot }}

                @if($iconRight)
                    <x-icon :name="$iconRight" :class="$iconClass" />
                @endif
            </button>
        HTML;
    }
}
