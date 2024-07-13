<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $textLeft = false,

        // Radio colors
        public bool $primary = true,
        public bool $secondary = false,
        public bool $warning = false,
        public bool $info = false,
        public bool $success = false,
        public bool $danger = false,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function colorClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-gray-600 focus:ring-gray-600',
            $this->warning => 'text-yellow-600 focus:ring-yellow-600',
            $this->success => 'text-green-600 focus:ring-green-600',
            $this->info => 'text-blue-600 focus:ring-blue-600',
            $this->danger => 'text-red-600 focus:ring-red-600',
            default => 'text-indigo-600 focus:ring-indigo-600', // primary
        };
    }

    public function sizeClasses(): string
    {
        return match (true) {
            $this->attributes->get('sm') => 'size-4',
            $this->attributes->get('lg') => 'size-6',
            $this->attributes->get('xl') => 'size-7',
            $this->attributes->get('xxl') => 'size-8',
            default => 'size-[18px]',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                
                $uuid = $uuid . $name;
                
                // Remove extra space & make label lowercase
                $label = trim(Str::lower($label));

                // Check if the label contains '*'
                $hasStar = strpos($label, '*') !== false;

                // Remove '*' from the label for translation
                $labelWithoutStar = rtrim($label, ' *');
            @endphp
                
            <div class="relative flex gap-x-3">
                @if($textLeft)
                    <div class="text-sm leading-6">
                        <label for="{{ $uuid }}" class="text-sm font-medium text-gray-700 capitalize ">
                            {{ __($labelWithoutStar) }}

                            @if ($hasStar || $attributes->get('required'))
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        
                        @if($hint)
                            <p class="text-gray-500">
                                {{ __($hint) }}
                            </p>
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                @endif

                <div class="flex items-center h-6">
                    <input id="{{ $uuid }}" type="radio"
                        {{ $attributes
                            ->class([
                                "border-gray-300",
                                $sizeClasses(), 
                                $colorClasses(),       
                                "!border-red-300" => $error,                                
                                "!text-gray-300 pointer-events-none" => $attributes->get('disabled') || $attributes->get('readonly'),                             
                            ])
                        }}
                    />
                </div>

                <!-- Default -->
                @if(!$textLeft)
                    <div class="text-sm leading-6">
                        <label for="{{ $uuid }}" class="text-sm font-medium text-gray-700 capitalize ">
                            {{ __($labelWithoutStar) }}

                            @if ($hasStar || $attributes->get('required'))
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        
                        @if($hint)
                            <p class="text-gray-500">
                                {{ __($hint) }}
                            </p>
                        @endif
                        
                        @if($error)
                            <p class="mt-0.5 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                @endif
            </div>
        HTML;
    }
}
