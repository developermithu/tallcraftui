<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatars extends Component
{
    public function __construct(
        public bool $stacked = false,
        public ?int $plus = null,
        public bool $ring = false,
        public string $ringColor = 'gray',
    ) {}

    public function sizeClass()
    {
        $sizeClasses = match (true) {
            $this->attributes->get('sm') => 'size-8 text-xs',
            $this->attributes->get('md') => 'size-[38px] text-sm',
            $this->attributes->get('lg') => 'size-[46px] text-base',
            $this->attributes->get('xl') => 'size-[62px] text-lg',
            default => 'size-[38px] text-sm',
        };

        return "{$sizeClasses}";
    }

    public function ringColor(): string
    {
        return match ($this->ringColor) {
            'primary' => 'ring-primary',
            'secondary' => 'ring-secondary',
            'black' => 'ring-black',
            'white' => 'ring-white',
            'slate' => 'ring-slate-400',
            'gray' => 'ring-gray-400',
            'zinc' => 'ring-zinc-400',
            'neutral' => 'ring-neutral-400',
            'stone' => 'ring-stone-400',
            'red' => 'ring-red-400',
            'orange' => 'ring-orange-400',
            'amber' => 'ring-amber-400',
            'yellow' => 'ring-yellow-400',
            'lime' => 'ring-lime-400',
            'green' => 'ring-green-400',
            'emerald' => 'ring-emerald-400',
            'teal' => 'ring-teal-400',
            'cyan' => 'ring-cyan-400',
            'sky' => 'ring-sky-400',
            'blue' => 'ring-blue-400',
            'indigo' => 'ring-indigo-400',
            'violet' => 'ring-violet-400',
            'purple' => 'ring-purple-400',
            'fuchsia' => 'ring-fuchsia-400',
            'pink' => 'ring-pink-400',
            'rose' => 'ring-rose-400',
            default => 'ring-primary',
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('avatar', $this->attributes);
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
                                    $sizeClass(),
                                    $ring ? "ring-2 ring-offset-2 {$ringColor()}" : ''
                                ]) 
                            }}
                        >+{{ $plus }}</a>
                    </div>
                @endif
            </div>
        HTML;
    }
}
