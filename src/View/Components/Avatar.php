<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Traits\AvatarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Avatar extends Component
{
    use AvatarTrait;

    public function __construct(
        public ?string $image = null,
        public ?string $alt = null,
        public ?string $text = null,
        public bool $badge = false,
        public ?string $badgeColor = null,
        public ?string $badgePosition = 'top',
        public bool $ring = false,
        public string $ringColor = 'slate',
    ) {
    }

    public function placeholderText(): string
    {
        $words = explode(' ', $this->text);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            return strtoupper(substr($this->text, 0, 2));
        }
    }

    public function placeholderClasses()
    {
        return $this->getAvatarBaseClasses() . ' flex items-center justify-center bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-200 font-semibold';
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
                                $getAvatarBaseClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 ring-offset-2 {$getRingColor()}" : ''
                            ]) 
                        }} 
                    />
                @elseif($text)
                    <div {{ $attributes->withoutTwMergeClasses()
                            ->twMerge([
                                $placeholderClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 ring-offset-2 {$getRingColor()}" : ''
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
                                $getAvatarBaseClasses(),
                                $roundedClass(),
                                $ring ? "ring-2 {$getRingColor()}" : ''
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
                    <span {{ $attributes->twMergeFor('badge', $getBadgeClasses(), $getBadgePosition(), 'ring-white dark:ring-gray-100' ) }}></span>
                @endif
            </div>
        HTML;
    }
}
