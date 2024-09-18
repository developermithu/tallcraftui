<?php

namespace Developermithu\Tallcraftui\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardFigure extends Component
{
    public function __construct(
        public ?string $img = null,
        public ?string $alt = null,
        public mixed $caption = null,
        public ?bool $overlay = false,
        public ?bool $hoverable = false,
    ) {}

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

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <figure 
                {{ $attributes->withoutTwMergeClasses()
                    ->twMerge([
                        'relative overflow-hidden group', 
                        str_replace('rounded', 'rounded-t', $roundedClass()),
                    ]) 
                }}
            >
                @if($img)
                    <img src="{{ $img }}"
                        alt="{{ $alt ?? 'Image' }}"
                        @class([
                            'w-full h-auto',
                            'group-hover:scale-110 transition duration-300' => $hoverable,
                            str_replace('rounded', 'rounded-t', $roundedClass()),
                        ])
                    >
                @endif    
            
                {{ $slot }}
                
                @if($caption)
                    <figcaption 
                        {{ $attributes->twMergeFor(
                            'caption', 
                            'absolute bottom-0 z-50 w-full px-5 py-2 text-sm text-gray-100 bg-transparent'
                        )}}
                    >   
                        {{ $caption }} 
                    </figcaption>
                @endif
                
                <div {{ $attributes->twMergeFor(
                        'overlay', 
                        'absolute inset-0 bg-black/20', 
                        str_replace('rounded', 'rounded-t', $roundedClass()), 
                        $overlay ? 'block' : 'hidden'
                    )}}
                ></div>
            </figure>
        HTML;
    }
}
