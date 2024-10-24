<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Developermithu\Tallcraftui\Helpers\BorderRadiusHelper;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ColorPicker extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?bool $inline = false,
        public ?bool $noPicker = false,
        public array $colors = [
            // Gray
            '#f9fafb',
            '#f3f4f6',
            '#e5e7eb',
            '#d1d5db',
            '#9ca3af',
            '#6b7280',
            '#4b5563',
            '#374151',
            '#1f2937',
            '#111827',

            // Neutral
            '#fafafa',
            '#f5f5f5',
            '#e5e5e5',
            '#d4d4d4',
            '#a3a3a3',
            '#737373',
            '#525252',
            '#404040',
            '#262626',
            '#171717',

            // Red
            '#fef2f2',
            '#fee2e2',
            '#fecaca',
            '#fca5a5',
            '#f87171',
            '#ef4444',
            '#dc2626',
            '#b91c1c',
            '#991b1b',
            '#7f1d1d',

            // Orange
            '#fff7ed',
            '#ffedd5',
            '#fed7aa',
            '#fdba74',
            '#fb923c',
            '#f97316',
            '#ea580c',
            '#c2410c',
            '#9a3412',
            '#7c2d12',

            // Amber
            '#fffbeb',
            '#fef3c7',
            '#fde68a',
            '#fcd34d',
            '#fbbf24',
            '#f59e0b',
            '#d97706',
            '#b45309',
            '#92400e',
            '#78350f',

            // Teal
            '#f0fdfa',
            '#ccfbf1',
            '#99f6e4',
            '#5eead4',
            '#2dd4bf',
            '#14b8a6',
            '#0d9488',
            '#0f766e',
            '#115e59',
            '#134e4a',

            // Blue
            '#eff6ff',
            '#dbeafe',
            '#bfdbfe',
            '#93c5fd',
            '#60a5fa',
            '#3b82f6',
            '#2563eb',
            '#1d4ed8',
            '#1e40af',
            '#1e3a8a',

            // Purple
            '#faf5ff',
            '#f3e8ff',
            '#e9d5ff',
            '#d8b4fe',
            '#c084fc',
            '#a855f7',
            '#9333ea',
            '#7e22ce',
            '#6b21a8',
            '#581c87',

            // Lime
            '#f7fee7',
            '#ecfccb',
            '#d9f99d',
            '#bef264',
            '#a3e635',
            '#84cc16',
            '#65a30d',
            '#4d7c0f',
            '#3f6212',
            '#365314',

            // Green
            '#f0fdf4',
            '#dcfce7',
            '#bbf7d0',
            '#86efac',
            '#4ade80',
            '#22c55e',
            '#16a34a',
            '#15803d',
            '#166534',
            '#14532d',

            // Sky
            '#f0f9ff',
            '#e0f2fe',
            '#bae6fd',
            '#7dd3fc',
            '#38bdf8',
            '#0ea5e9',
            '#0284c7',
            '#0369a1',
            '#075985',
            '#0c4a6e',

            // Violet
            '#f5f3ff',
            '#ede9fe',
            '#ddd6fe',
            '#c4b5fd',
            '#a78bfa',
            '#8b5cf6',
            '#7c3aed',
            '#6d28d9',
            '#5b21b6',
            '#4c1d95',

            // Fuchsia
            '#fdf4ff',
            '#fae8ff',
            '#f5d0fe',
            '#f0abfc',
            '#e879f9',
            '#d946ef',
            '#c026d3',
            '#a21caf',
            '#86198f',
            '#701a75',

            // Pink
            '#fdf2f8',
            '#fce7f3',
            '#fbcfe8',
            '#f9a8d4',
            '#f472b6',
            '#ec4899',
            '#db2777',
            '#be185d',
            '#9d174d',
            '#831843',
        ],
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function roundedClass(): string
    {
        return BorderRadiusHelper::getRoundedClass('input', $this->attributes);
    }

    public function disableClass(): string
    {
        return $this->attributes->get('disabled') ? 'bg-gray-200 opacity-80 cursor-not-allowed' : '';
    }

    public function readonlyClass(): string
    {
        return $this->attributes->get('readonly') ? 'bg-gray-200 opacity-80 border-gray-400 border-dashed pointer-events-none' : '';
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            @php
                $name = $attributes->wire('model')->value();
                $error = $errors->has($name) ? $errors->first($name) : null;
                $uuid = $uuid . $name;
                $required = $attributes->get('required') ? true : false;
                $errorClass = $error ? 'border-red-500 dark:border-red-500 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500': '';
            @endphp

            <div 
                x-data="{
                    color: @entangle($attributes->wire('model')),
                    isOpen: false,
                    presetColors: {{ json_encode($colors) }},
                    togglePicker() {
                        event.preventDefault();
                        this.isOpen = !this.isOpen;
                    },
                    closeColorPicker() {
                        this.isOpen = false;
                    },
                    setColor(newColor) {
                        this.color = newColor;
                        this.closeColorPicker();
                    }
                }"
                @click.away="closeColorPicker()"
                @class(['flex items-center gap-3' => $inline])
            >
                @if($label)
                    <x-tc-label :for="$uuid" :label="$label" :required="$required" :inline="$inline" {{ $attributes->twMergeFor('label') }} />
                 @endif

                <div class="relative flex items-center flex-1">
                    <div class="w-full">
                        <div class="absolute w-12 h-full border-r rounded-l dark:border-gray-700" :style="{ backgroundColor: $wire.{{ $attributes->wire('model')->value() }} }">
                            <input
                                type="color"
                                class="block w-full h-full opacity-0 cursor-pointer"
                                {{ $attributes->wire('model') }}
                            />
                        </div>
                    
                        <input
                            id="{{ $uuid }}"
                            type="text"
                            x-model="color"
                            @input="$wire.set('{{ $attributes->wire('model')->value() }}', $event.target.value)"
                            placeholder="{{ $attributes->whereStartsWith('placeholder')->first() }}"
                            {{ 
                                $attributes
                                    ->withoutTwMergeClasses()
                                    ->twMerge([
                                        "block w-full border-gray-200 pl-14 py-2.5 shadow-sm text-sm outline-none focus:ring-primary focus:border-primary dark:focus:border-primary dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:placeholder-gray-400",
                                        $disableClass(),
                                        $readonlyClass(),
                                        $roundedClass(),
                                        $errorClass,
                                    ])
                            }} 
                        />
                    </div>

                    @if(!$noPicker)
                        <button
                            type="button"
                            @click="togglePicker"
                            class="absolute inset-y-0 grid w-10 end-0 place-content-center"
                        >
                            <x-tc-icon name="swatch" {{ $attributes->twMergeFor('icon', 'dark:text-gray-400 size-4') }} />
                        </button>
                    @endif
                    
                    @if(!$noPicker)
                        <div
                            x-cloak
                            x-show="isOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2 bg-white border border-gray-200 rounded dark:bg-gray-800 dark:border-gray-700 top-11"
                        >
                            <div class="grid grid-cols-10 gap-1.5 p-3 overflow-y-auto max-h-56" style="scrollbar-width: thin">
                                <template x-for="presetColor in presetColors" :key="presetColor">
                                    <div
                                        @click="setColor(presetColor)"
                                        class="w-5 h-5 duration-200 rounded cursor-pointer hover:scale-110"
                                        :style="{ backgroundColor: presetColor }"
                                    ></div>
                                </template>
                            </div>
                        </div>
                    @endif
                </div>

                @if($hint && !$error)
                    <x-tc-hint :hint="$hint" />
                @endif

                @if($error)
                    <p class="mt-1 text-sm text-red-500"> {{ $error }} </p>
                @endif
            </div>
        HTML;
    }
}
