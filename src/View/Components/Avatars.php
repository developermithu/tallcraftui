<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\AvatarsTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatars extends Component
{
    use AvatarsTrait;

    public function __construct(
        public bool $stacked = false,
        public ?int $plus = null,
        public bool $ring = false,
        public string $ringColor = 'gray',
    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div class="flex items-start {{ $stacked ? '-space-x-3' : 'space-x-2' }}">
                {{ $slot }}
                @if($plus)
                    <div class="relative inline-block">
                        <a href="#" 
                                {{ $attributes->twMerge([
                                    'flex items-center justify-center text-xs font-medium text-white bg-gray-400 dark:bg-gray-500 hover:bg-gray-500 dark:hover:bg-gray-600',
                                    $roundedClass(),
                                    $getSizeClasses(),
                                    $ring ? "ring-2 ring-offset-2 {$getRingColor()}" : ''
                                ]) 
                            }}
                        >+{{ $plus }}</a>
                    </div>
                @endif
            </div>
        HTML;
    }
}
