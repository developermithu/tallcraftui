<?php

namespace Developermithu\Tallcraftui\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public function __construct(
        public ?string $icon = null,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $actions = null,

        // Alert types
        public bool $primary = true,
        public bool $secondary = false,
        public bool $warning = false,
        public bool $info = false,
        public bool $success = false,
        public bool $danger = false,

        public bool $dismissible = false,
        public ?array $errors = null,
    ) {
    }

    public function alertIcon(): string
    {
        return $this->icon ?: match (true) {
            $this->warning => 'exclamation-triangle',
            $this->info || $this->secondary => 'information-circle',
            $this->danger => 'x-circle',
            default => 'check-circle',
        };
    }

    public function alertClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-gray-600 border-gray-200 bg-gray-50 dark:bg-gray-800/10 dark:border-gray-900 dark:text-gray-500',
            $this->warning => 'text-yellow-800 border-yellow-200 bg-yellow-50 dark:bg-yellow-800/10 dark:border-yellow-900 dark:text-yellow-500',
            $this->info => 'text-blue-800 border-blue-200 bg-blue-50 dark:bg-blue-800/10 dark:border-blue-900 dark:text-blue-500',
            $this->danger => 'text-red-800 border-red-200 bg-red-50 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500',
            $this->success => 'text-teal-800 border-teal-200 bg-teal-50 dark:bg-teal-800/10 dark:border-teal-900 dark:text-teal-500',
            default => 'text-indigo-800 border-indigo-200 bg-indigo-50 dark:bg-indigo-800/10 dark:border-indigo-900 dark:text-indigo-500',
        };
    }

    public function descriptionClasses(): string
    {
        return match (true) {
            $this->secondary => 'text-gray-700 dark:text-gray-400',
            $this->warning => 'text-yellow-700 dark:text-yellow-400',
            $this->info => 'text-blue-700 dark:text-blue-400',
            $this->danger => 'text-red-700 dark:text-red-400',
            $this->success => 'text-teal-700 dark:text-teal-400',
            default => 'text-indigo-700 dark:text-indigo-400',
        };
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
            <div 
                x-data="{ visible: true }"
                x-show="visible"
                x-cloak
                x-transition.duration.500ms.opacity
                @class(["p-4 text-sm transition duration-300 border rounded-lg", $alertClasses()])>
                <div class="flex">
                    <div class="flex-shrink-0">
                        <x-icon :name="$alertIcon()" class="size-6" />
                    </div>

                    <div @class(["ms-2","ms-4" => $description])>
                        <h3 class="text-sm font-medium">
                            {{ $title ?? $errors ? 'Something wents wrong!' : 'Alert title goes here' }}
                        </h3>
                        
                        @if($description)
                            <div @class(["mt-1 text-sm", $descriptionClasses()])>
                                {{ $description }}
                            </div>
                        @endif
                        
                        @if($errors)
                            <ul @class(["mt-2 text-sm list-disc space-y-1 ps-5", $descriptionClasses()])>
                                @foreach($errors as $error)
                                    <li> {{ $error }} </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    
                    <div class="ps-3 ms-auto">
                        <div class="-mx-1.5 -my-1.5">
                        @if($dismissible && !$actions)
                                @if($secondary) <x-button @click="visible = false" icon="x-mark" flat circle sm secondary /> @endif
                                @if($warning) <x-button @click="visible = false" icon="x-mark" flat circle sm warning /> @endif
                                @if($info) <x-button @click="visible = false" icon="x-mark" flat circle sm info /> @endif
                                @if($danger) <x-button @click="visible = false" icon="x-mark" flat circle sm danger /> @endif
                                @if($success) <x-button @click="visible = false" icon="x-mark" flat circle sm success /> @endif
                                @if(!$secondary && !$warning && !$info && !$danger && !$success ) 
                                    <x-button @click="visible = false" icon="x-mark" flat circle sm /> 
                                @endif
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
