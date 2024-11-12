<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    public function __construct(
        public ?string $image = null,
        public ?string $alt = null,
        public ?string $text = null,
        public bool $badge = false,
        public ?string $badgeColor = null,
        public ?string $badgePosition = 'top',
        public bool $ring = false,
        public string $ringColor = 'slate',
    ) {}

    public function baseClasses()
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

    public function badgeClasses()
    {
        $badgeColors = match (true) {
            $this->badgeColor === 'primary' => 'bg-primary',
            $this->badgeColor === 'secondary' => 'bg-secondary',
            $this->badgeColor === 'black' => 'bg-black',
            $this->badgeColor === 'white' => 'bg-white',
            $this->badgeColor === 'slate' => 'bg-slate-500',
            $this->badgeColor === 'gray' => 'bg-gray-500',
            $this->badgeColor === 'zinc' => 'bg-zinc-500',
            $this->badgeColor === 'neutral' => 'bg-neutral-500',
            $this->badgeColor === 'stone' => 'bg-stone-500',
            $this->badgeColor === 'red' => 'bg-red-500',
            $this->badgeColor === 'orange' => 'bg-orange-500',
            $this->badgeColor === 'amber' => 'bg-amber-500',
            $this->badgeColor === 'yellow' => 'bg-yellow-500',
            $this->badgeColor === 'lime' => 'bg-lime-500',
            $this->badgeColor === 'green' => 'bg-green-500',
            $this->badgeColor === 'emerald' => 'bg-emerald-500',
            $this->badgeColor === 'teal' => 'bg-teal-500',
            $this->badgeColor === 'cyan' => 'bg-cyan-500',
            $this->badgeColor === 'sky' => 'bg-sky-500',
            $this->badgeColor === 'blue' => 'bg-blue-500',
            $this->badgeColor === 'indigo' => 'bg-indigo-500',
            $this->badgeColor === 'violet' => 'bg-violet-500',
            $this->badgeColor === 'purple' => 'bg-purple-500',
            $this->badgeColor === 'fuchsia' => 'bg-fuchsia-500',
            $this->badgeColor === 'pink' => 'bg-pink-500',
            $this->badgeColor === 'rose' => 'bg-rose-500',
            default => 'bg-primary',
        };

        $sizeClasses = match (true) {
            $this->attributes->get('sm') => 'size-1.5',
            $this->attributes->get('md') => 'size-2.5',
            $this->attributes->get('lg') => 'size-3',
            $this->attributes->get('xl') => 'size-3.5',
            default => 'size-2.5',
        };

        return "absolute block {$sizeClasses} rounded-full {$badgeColors} ring-2";
    }

    public function badgePosition(): string
    {
        $isSquare = $this->roundedClass() !== 'rounded-full';

        return match ($this->badgePosition) {
            'top' => $isSquare
                ? 'top-0 end-0 transform -translate-y-1/2 translate-x-1/2'
                : 'top-0 end-0',
            'bottom' => $isSquare
                ? 'bottom-0 end-0 transform translate-y-1/2 translate-x-1/2'
                : 'bottom-0 end-0',
            default => 'top-0 end-0',
        };
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

    public function placeholderText(): string
    {
        $words = explode(' ', $this->text);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1).substr($words[1], 0, 1));
        } else {
            return strtoupper(substr($this->text, 0, 2));
        }
    }

    public function placeholderClasses()
    {
        return $this->baseClasses().' flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 font-semibold';
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('avatar', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div class="relative inline-block w-fit">
                @if($image)
                    <img src="{{ $image }}" alt="{{ $alt }}" 
                        {{ $attributes->withoutTwMergeClasses()
                            ->twMerge([
                                'inline-block object-cover',
                                $baseClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 ring-offset-2 {$ringColor()}" : ''
                            ]) 
                        }} 
                    />
                @elseif($text)
                    <div {{ $attributes->withoutTwMergeClasses()
                            ->twMerge([
                                $placeholderClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 ring-offset-2 {$ringColor()}" : ''
                            ]) 
                        }}  
                    >
                        {{ $placeholderText() }}
                    </div>
                @else 
                    <span 
                        {{ $attributes->withoutTwMergeClasses()
                            ->twMerge([
                                'inline-block bg-gray-100 overflow-hidden',
                                $baseClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 {$ringColor()}" : ''
                            ]) 
                        }}  
                    >
                        <svg class="text-gray-300 dark:text-gray-400 size-full" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.62854" y="0.359985" width="15" height="15" rx="7.5" fill="white"></rect>
                            <path d="M8.12421 7.20374C9.21151 7.20374 10.093 6.32229 10.093 5.23499C10.093 4.14767 9.21151 3.26624 8.12421 3.26624C7.0369 3.26624 6.15546 4.14767 6.15546 5.23499C6.15546 6.32229 7.0369 7.20374 8.12421 7.20374Z" fill="currentColor"></path>
                            <path d="M11.818 10.5975C10.2992 12.6412 7.42106 13.0631 5.37731 11.5537C5.01171 11.2818 4.69296 10.9631 4.42107 10.5975C4.28982 10.4006 4.27107 10.1475 4.37419 9.94123L4.51482 9.65059C4.84296 8.95684 5.53671 8.51624 6.30546 8.51624H9.95231C10.7023 8.51624 11.3867 8.94749 11.7242 9.62249L11.8742 9.93184C11.968 10.1475 11.9586 10.4006 11.818 10.5975Z" fill="currentColor"></path>
                        </svg>
                    </span>
                @endif
                
                @if($badge || $badgeColor)
                    <span {{ $attributes->twMergeFor('badge', $badgeClasses(), $badgePosition(), 'ring-white dark:ring-gray-100' ) }}></span>
                @endif
            </div>
        HTML;
    }
}
