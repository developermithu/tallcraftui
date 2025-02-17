<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\HasButtonColors;
use Developermithu\Tallcraftui\Traits\HasButtonSizes;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    use HasButtonSizes, HasButtonColors;

    public function __construct(
        // Button content
        public ?string $label = null,
        public ?string $icon = null,
        public ?string $iconLeft = null,
        public ?string $iconRight = null,

        // Button Default Type
        public bool $primary = true,

        // Button as link
        public ?string $link = null,
        public ?bool $external = false,
        public ?bool $noWireNavigate = false,

        // Button spinner
        public ?string $spinner = null,
        public ?bool $spinnerBars = false,
        public ?bool $spinnerDots = false,
        public ?bool $spinnerPulse = false,
    ) {}

    public function spinnerTarget(): ?string
    {
        return $this->spinner == 1 ? $this->attributes->whereStartsWith('wire:click')->first() : $this->spinner;
    }

    public function buttonBaseClasses(): string
    {
        return 'inline-flex gap-x-1.5 items-center border border-transparent w-fit justify-center font-semibold text-xs uppercase tracking-widest disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-200 dark:focus:ring-offset-0';
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('button', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @if($link)
                <a href="{{ $link }}"
            @else
                <button 
            @endif

                @if($link && $external)
                    target="_blank"
                @endif

                @if($link && !$external && !$noWireNavigate)
                    wire:navigate
                @endif
                    
                @if(!$link)
                    wire:loading.attr="disabled" wire:target="{{ $spinnerTarget() }}"
                    {{ $attributes->whereDoesntStartWith('class')->merge(['type' => 'submit']) }}
                @endif
                
                {{ $attributes
                        ->except($colorAttributes)
                        ->withoutTwMergeClasses()
                        ->twMerge([
                            $buttonBaseClasses(), 
                            $roundedClass(), 
                            $getColorClasses(), 
                            $getOutlineClasses(),
                            $getFlatClasses(),
                            $getSizeClasses(), 
                            $getCircleClasses(),
                        ]) 
                    }}
                >
                
                @if($icon)
                    <x-tc-icon :name="$icon" {{ $attributes->twMergeFor('icon', $getCircleIconSize()) }} />
                @elseif ($iconLeft)
                    <x-tc-icon :name="$iconLeft" {{ $attributes->twMergeFor('icon', $getCircleIconSize()) }} />
                @endif

                {{ $label ? __($label) : '' }}

                {{ $slot }}

                @if($iconRight && !$spinner)
                    <x-tc-icon :name="$iconRight" {{ $attributes->twMergeFor('icon', $getCircleIconSize()) }} />
                @endif

                @if($spinner)
                    @if($spinnerBars)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" bars xs />
                    @elseif($spinnerDots)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="fill-white/80" dots xs />
                    @elseif($spinnerPulse)
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" pulse xs />
                    @else
                        <x-tc-spinner wire:loading wire:target="{{ $spinnerTarget() }}" class="text-white/80" xs />
                    @endif
                @endif

            @if($link)
                </a>
            @else
                </button>
            @endif
        HTML;
    }
}
