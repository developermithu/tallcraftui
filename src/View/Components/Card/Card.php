<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Developermithu\Tallcraftui\Helpers\ShadowHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct() {}

    public function roundedClass(): string
    {
        $default = config('tallcraftui.card.border-radius', 'rounded-lg');

        return match (true) {
            $default === 'rounded' => 'rounded',
            $default === 'rounded-sm' => 'rounded-sm',
            $default === 'rounded-md' => 'rounded-md',
            $default === 'rounded-lg' => 'rounded-lg',
            $default === 'rounded-xl' => 'rounded-xl',
            $default === 'rounded-2xl' => 'rounded-2xl',
            $default === 'rounded-3xl' => 'rounded-3xl',
            $default === 'rounded-full' => 'rounded-full',
            $default === 'rounded-none' => 'rounded-none',
            default => 'rounded-lg',
        };
    }

    public function shadowClass(): string
    {
        return ShadowHelper::getShadowClass('card', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div {{ $attributes->twMerge([
                    'border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800',
                    $roundedClass(),
                    $shadowClass(),
                ])
            }}>            
                {{ $slot }}
            </div>
        HTML;
    }
}
