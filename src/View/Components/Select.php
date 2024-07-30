<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?Collection $options = null,
        public ?string $placeholder = null,
        public ?string $hint = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundClasses()
    {
        return match (true) {
            $this->attributes->get('rounded-none') => 'rounded-none',
            $this->attributes->get('rounded-sm') => 'rounded-sm',
            $this->attributes->get('rounded-md') => 'rounded-md',
            $this->attributes->get('rounded-lg') => 'rounded-lg',
            $this->attributes->get('rounded-xl') => 'rounded-xl',
            $this->attributes->get('rounded-2xl') => 'rounded-2xl',
            $this->attributes->get('rounded-3xl') => 'rounded-3xl',
            $this->attributes->get('rounded-full') => 'rounded-full',
            default => 'rounded',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div>
                @php
                    $name = $attributes->wire('model')->value();
                    $error = $errors->has($name) ? $errors->first($name) : null;
                    $uuid = $uuid . $name;
                    $required = $attributes->get('required') ? true : false;
                @endphp
            
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" />
                 @endif

                <div class="relative flex items-center flex-1">
                    <div class="w-full">
                        <select
                            id="{{ $uuid }}"
                            {{ 
                                $attributes
                                    ->class([
                                        "block w-full border-gray-200 py-2.5 shadow-sm text-sm outline-none focus:ring-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300",
                                        "border-red-500 focus:border-red-500 focus:ring-red-500" => $error,
                                        "bg-gray-200 opacity-80 cursor-not-allowed" => $attributes->get('disabled'),
                                        "bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none" => $attributes->get('readonly'),
                                        $roundClasses(),
                                    ])
                             }}>
                    
                            @if (!$options->isEmpty())
                                <option value="">-- {{ __($placeholder ?? 'choose option') }} -- </option>

                                @foreach ($options as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            @else
                                {{ $slot }}
                            @endif
                        </select>

                        @if($hint && !$error)
                            <x-tc-hint :hint="$hint" />
                        @endif
                        
                        @if($error)
                            <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                        @endif
                    </div>
                </div>
            </div>
        HTML;
    }
}
