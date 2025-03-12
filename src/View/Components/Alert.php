<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Developermithu\Tallcraftui\Traits\Colors\HasAlertColors;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    use HasAlertColors;

    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $actions = null,

        public bool $dismissible = false,
        public ?array $errors = null,
    ) {
    }

    public function alertIcon(): string
    {
        return $this->icon ?: match (true) {
            $this->attributes->get('yellow') || $this->attributes->get('orange') || $this->attributes->get('amber') => 'exclamation-triangle',
            $this->attributes->get('blue') || $this->attributes->get('secondary') => 'information-circle',
            $this->attributes->get('red') => 'x-circle',
            default => 'check-circle',
        };
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('alert', $this->attributes);
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $alertTitle = $title ?? ($errors ? 'Something went wrong!' : 'Alert title goes here');
            @endphp
            
            <div 
                x-data="{ visible: true }"
                x-show="visible"
                x-cloak
                x-transition.duration.500ms.opacity
                    {{ $attributes
                        ->withoutTwMergeClasses()
                        ->except($colorAttributes)
                        ->twMerge([
                            "p-3 text-sm transition duration-300 border", 
                            $getAlertClasses(), 
                            $roundedClass()
                        ]) 
                    }}
                >
                <div class="flex items-start">
                    <div class="shrink-0">
                        <x-tc-icon :name="$alertIcon()" class="size-5 opacity-80 {{ $errors ? 'text-red-500': '' }}" />
                    </div>

                    <div @class(["ms-2","sm:ms-4" => $description])>
                        <h3 @class(["text-sm font-medium", $getAlertTextColor()])>
                            {{ $alertTitle }}
                        </h3>
                        
                        @if($description)
                            <div @class(["mt-1 text-sm opacity-90", $getAlertTextColor()])>
                                {{ $description }}
                            </div>
                        @endif
                        
                        @if($errors)
                            <ul @class(["mt-2 text-sm list-disc space-y-1 ps-5", $getAlertTextColor()])>
                                @foreach($errors as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                            @if($dismissible && !$actions)
                                <button @click="visible = false"
                                        {{ $attributes->twMergeFor(
                                                "action",
                                                "flex items-center justify-center transition duration-200 ease-in-out bg-transparent rounded-full focus:outline-hidden focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-0 size-8",
                                                $getAlertActionColors(),
                                            )
                                        }}
                                    >
                                        <x-tc-icon name="x-mark" />
                                </button>
                            @else 
                                {{ $actions }}    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
